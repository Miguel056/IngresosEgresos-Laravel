<?php

namespace App\Listeners;

use App\Events\IngresosEvent;
use App\Models\Total;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IngresosListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(IngresosEvent $event): void
    {
        $mes = "" . date("F");
        $year = "" . date("Y");
        $ingresos = DB::table('totals')
            ->where([['month', $mes], ['year', $year], ['user_id', "=", Auth::id()]])
            ->get();

        $total = count($ingresos);
        if ($total == 0) {
            Total::create([
                'total_ingreso' => $event->ingreso->amount,
                'total_egreso' => 0,
                'total' => $event->ingreso->amount,
                'month' => $mes,
                'year' => $year,
                'user_id' => Auth::id()
            ]);
        } else {
            foreach ($ingresos as $ingreso) {
                $item = Total::find($ingreso->id);
            }
            $totalIngreso = $item->total_ingreso + $event->ingreso->amount;
            $totalAll = $item->total + $event->ingreso->amount;

            $item->total_ingreso = $totalIngreso;
            $item->total = $totalAll;
            $item->save();
        }
    }
}
