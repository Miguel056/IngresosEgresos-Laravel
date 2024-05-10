<?php

namespace App\Http\Controllers;

use App\Events\EgresosEvent;
use App\Events\IngresosEvent;
use App\Http\Requests\FinanzasRequest;
use App\Models\Egreso;
use App\Models\Ingreso;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FinanzasController extends Controller
{
    public function ordenarDatos()
    {
        $mes = "" . date("F");
        $year = "" . date("Y");
        $mesI = strtolower($mes);
        $mesA = $this->mes($mesI);
        $egresos = DB::table('egresos')
            ->where([['month', $mes], ['year', $year], ['user_id', "=", Auth::id()]])
            ->get();
        $ingresos = DB::table('ingresos')
            ->where([['month', $mes], ['year', $year], ['user_id', "=", Auth::id()]])
            ->get();
        foreach ($egresos as $egreso) {
            $egreso->amount = $egreso->amount * -1;
        }
        $datos = $ingresos->concat($egresos);
        foreach ($datos as $dato) {
            $dato->registration_date = Carbon::parse($dato->registration_date)->format('Y-m-d');
        }
        $ordenados = $datos->sortBy('registration_date');
        $array = Collection::make();
        foreach ($ordenados as $orden) {
            $array->push($orden);
        }
        return Inertia::render('Mayores', ['ordenados' => $array, 'mes' => $mesA, 'year' => $year]);
    }

    public function preSeeHistorial()
    {
        return Inertia::render('PreHistorial');
    }

    public function historialActual()
    {
        $mes = "" . date("F");
        $year = "" . date("Y");
        $mesI = strtolower($mes);
        $mesA = $this->mes($mesI);
        $egresos = DB::table('egresos')
            ->where([['month', $mes], ['year', $year], ['user_id', "=", Auth::id()]])
            ->get();
        $ingresos = DB::table('ingresos')
            ->where([['month', $mes], ['year', $year], ['user_id', "=", Auth::id()]])
            ->get();
        $totales = DB::table('totals')
            ->where([['month', $mes], ['year', $year], ['user_id', "=", Auth::id()]])
            ->get();
        return Inertia::render('Historial', ['ingresos' => $ingresos, 'egresos' => $egresos, 'mes' => $mesA, 'year' => $year, 'totales' => $totales, 'mesI' => $mesI]);
    }

    public function seeHistorial(Request $request)
    {
        $mes = $this->mes($request->month);
        $ingresos = DB::table('ingresos')
            ->where([['month', $request->month], ['year', $request->year], ['user_id', "=", Auth::id()]])
            ->get();
        $egresos = DB::table('egresos')
            ->where([['month', $request->month], ['year', $request->year], ['user_id', "=", Auth::id()]])
            ->get();
        $totales = DB::table('totals')
            ->where([['month', $request->month], ['year', $request->year], ['user_id', "=", Auth::id()]])
            ->get();
        return Inertia::render('Historial', ['ingresos' => $ingresos, 'egresos' => $egresos, 'mes' => $mes, 'year' => $request->year, 'totales' => $totales, 'mesI' => $request->month]);
    }

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

    public function mes($month)
    {
        $mes = "";
        switch ($month) {
            case "january":
                $mes = "Enero";
                break;
            case "february":
                $mes = "Febrero";
                break;
            case "march":
                $mes = "Marzo";
                break;
            case "april":
                $mes = "Abril";
                break;
            case "may":
                $mes = "Mayo";
                break;
            case "june":
                $mes = "Junio";
                break;
            case "july":
                $mes = "Julio";
                break;
            case "august":
                $mes = "Agosto";
                break;
            case "september":
                $mes = "Septiembre";
                break;
            case "october":
                $mes = "Octubre";
                break;
            case "november":
                $mes = "Noviembre";
                break;
            case "december":
                $mes = "Diciembre";
                break;
        }
        return $mes;
    }
}
