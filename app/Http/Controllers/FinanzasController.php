<?php

namespace App\Http\Controllers;

use App\Events\EgresosEvent;
use App\Events\IngresosEvent;
use App\Http\Requests\FinanzasRequest;
use App\Models\Egreso;
use App\Models\Ingreso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FinanzasController extends Controller
{
    public function sinIva()
    {
        $mes = "" . date("F");
        $year = "" . date("Y");
        $egresos = DB::table('egresos')
            ->where([['month', $mes], ['year', $year], ['user_id', "=", Auth::id()]])
            ->get();
        return Inertia::render('SinIVA', ['egresos' => $egresos]);
    }

    public function readEgresos()
    {
        $mes = "" . date("F");
        $year = "" . date("Y");
        $egresos = DB::table('egresos')
            ->where([['month', $mes], ['year', $year], ['user_id', "=", Auth::id()]])
            ->get();
        return Inertia::render('Egresos', ['egresos' => $egresos]);
    }

    public function readIngresos()
    {
        $mes = "" . date("F");
        $year = "" . date("Y");
        $ingresos = DB::table('ingresos')
            ->where([['month', $mes], ['year', $year], ['user_id', "=", Auth::id()]])
            ->get();
        return Inertia::render('Ingresos', ['ingresos' => $ingresos]);
    }

    public function store(FinanzasRequest $request): RedirectResponse
    {
        if ($request->type == 0) {
            $ingreso = Ingreso::create([
                'amount' => $request->amount,
                'registration_date' => $request->date,
                'description' => $request->description,
                'month' => "" . date("F"),
                'year' => "" . date("Y"),
                'user_id' => Auth::id()
            ]);
            IngresosEvent::dispatch($ingreso);
        }
        if ($request->type == 1) {
            if ($request->hasFile('file')) {
                $file_name =  time() . '.' . $request->file->extension();
                $request->file->storeAs('public/egresos', $file_name);
            } else {
                $file_name = NULL;
            }
            $egreso = Egreso::create([
                'amount' => $request->amount,
                'registration_date' => $request->date,
                'description' => $request->description,
                'month' => "" . date("F"),
                'year' => "" . date("Y"),
                'file_uri' =>  $file_name,
                'user_id' => Auth::id()
            ]);
            EgresosEvent::dispatch($egreso);
        }
        return redirect(route('registro', absolute: false));
    }
}
