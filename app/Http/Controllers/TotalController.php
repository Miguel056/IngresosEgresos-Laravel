<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TotalController extends Controller
{
    public function readTotal()
    {
        $mes = "" . date("F");
        $year = "" . date("Y");
        $totales = DB::table('totals')
            ->where([['month', $mes], ['year', $year], ['user_id', "=", Auth::id()]])
            ->get();
        return Inertia::render('Totales', ['totales' => $totales]);
    }
}
