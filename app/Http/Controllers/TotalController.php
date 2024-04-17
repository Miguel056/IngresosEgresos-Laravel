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
        $gastos = DB::table('egresos')
            ->where([['month', $mes], ['year', $year], ['user_id', "=", Auth::id()]])
            ->orderBy('amount', 'desc')
            ->limit(5)
            ->get();
        return Inertia::render('Totales', ['totales' => $totales, 'egresos' => $gastos]);
    }
}
