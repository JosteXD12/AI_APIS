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
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer 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",
            ])->post("https://api.openai.com/v1/images/generations", [
                    'prompt' => $request->input('prompt'),
                    'n'      => 1,
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
