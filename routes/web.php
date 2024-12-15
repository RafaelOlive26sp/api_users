<?php

use Illuminate\Support\Facades\Route;

Route::get('/docs/api-docs.json', function () {
    $filePath = storage_path('app/api-docs/api-docs.json');

    if (file_exists($filePath)) {
        return response()->json(json_decode(file_get_contents($filePath)));
    }

    return response()->json(['error' => 'Arquivo não encontrado'], 404);
});
