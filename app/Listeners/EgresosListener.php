<?php

namespace App\Listeners;

use App\Events\EgresosEvent;
use App\Models\Total;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EgresosListener
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
    public function handle(EgresosEvent $event): void
    {
        $mes = "" . date("F");
        $year = "" . date("Y");
        $egresos = DB::table('totals')
            ->where([['month', $mes], ['year', $year], ['user_id', "=", Auth::id()]])
            ->get();

        $total = count($egresos);
        if ($total == 0) {
            Total::create([
                'total_ingreso' => 0,
                'total_egreso' => $event->egreso->amount,
                'total' => $event->egreso->amount * -1,
                'month' => $mes,
                'year' => $year,
                'user_id' => Auth::id()
            ]);
        } else {
            foreach ($egresos as $egreso) {
                $item = Total::find($egreso->id);
            }
            $totalEgreso = $item->total_egreso + $event->egreso->amount;
            $totalAll = $item->total - $event->egreso->amount;

            $item->total_egreso = $totalEgreso;
            $item->total = $totalAll;
            $item->save();
        }
    }
}
