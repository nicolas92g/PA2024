<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function show($filename)
    {
        return response()->json($filename);

        $filePath = '../WEBSITE/' . $filename;

        if (file_exists('')) {
            return response()->file($filePath);
        } else {
            abort(400, 'ERROR');
        }
    }
}
