<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use App\Models\Ingreso;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanzasController extends Controller
{
    public function store(Request $request): RedirectResponse{
        if($request->type == 0){
            Ingreso::create([
                'amount' => $request->amount,
                'registration_date' => $request->date,
                'description' => $request->description,
                'month' => "".date("F"),
                'year' => "".date("Y"),
                'user_id' => Auth::id()
            ]);
        }
        if($request->type == 1){
            Egreso::create([
                'amount' => $request->amount,
                'registration_date' => $request->date,
                'description' => $request->description,
                'month' => "".date("F"),
                'year' => "".date("Y"),
                'user_id' => Auth::id()
            ]);
        }
        return redirect(route('registro', absolute:false));
    }
}
