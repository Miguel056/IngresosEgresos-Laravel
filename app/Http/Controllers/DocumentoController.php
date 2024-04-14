<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentoController extends Controller
{
    public function seeDocument($url)
    {
        $tiene = str_contains($url, ".pdf");
        if ($tiene) {
            //dd('tenemos pdf');
            return Inertia::render('Documento', ['documento' => $url, 'url' => "/storage/egresos/" . $url]);
        } else {
            return Inertia::render('Imagenes', ['documento' => $url, 'url' => "/storage/egresos/" . $url]);
        }
    }
}
