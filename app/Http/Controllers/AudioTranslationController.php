<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;

class AudioTranslationController extends Controller
{
    public function upload()
    {
        return view('audio-translation.upload');
    }

    public function process(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:mp3,mp4,mpeg,mpga,m4a,wav,webm',
        ]);

        $file = $request->file('file');

        if ($file) {
            echo "Nombre del archivo: " . $file->getClientOriginalName();
            echo "Tipo MIME: " . $file->getClientMimeType();
            echo "Tamaño del archivo: " . $file->getSize();
        } else {
            echo "No se ha cargado ningún archivo.";
        }
        


        $filePath = $request->file('file')->getRealPath();
        Log::info('Ruta del archivo:', ['path' => $filePath]);


        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/audio/transcriptions', [
            'headers' => [
                'Authorization' => 'Bearer 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',
            ],
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($filePath, 'r'),
                ],
                [
                    'name' => 'timestamp_granularities[]',
                    'contents' => 'word',
                ],
                [
                    'name' => 'model',
                    'contents' => 'whisper-1',
                ],
                [
                    'name' => 'response_format',
                    'contents' => 'verbose_json',
                ],
            ],
        ]);

        $responseBody = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() === 200) {
            $transcription = $responseBody['text'];
            // Puedes acceder a la información detallada, como las palabras y sus marcas de tiempo, a través de $responseBody['words']
            return view('audio-translation.result', ['transcription' => $transcription]);
        } else {
            Log::error('Error al realizar la transcripción de audio:', ['respuesta' => $response->getBody()->getContents()]);
            return back()->with('error', 'Error al realizar la transcripción de audio.');
        }
    }
}
