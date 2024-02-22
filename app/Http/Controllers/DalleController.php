<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Exception;

class DalleController extends Controller
{
    public function index()
    {
        return view('dalle.index'); // Reemplaza por la ruta de tu vista
    }

    public function generateImage(Request $request)
    {

        $openaiApiKey = config('openai.api_key');


        $apiUrl = 'https://api.openai.com/v1/images/generations';
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $openaiApiKey,
            ])->post($apiUrl, [
                        'prompt' => $request->input('prompt'),
                        'n' => 1,
                    ]);

            if ($response->successful()) {
                return response()->json($response['data'][0]['url']);
            } else {
                throw new Exception("Error al generar imagen");
            }
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
