<?php


namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Order;
use Illuminate\Support\Facades\DB;

class ChartsComposer
{

    public function compose(View $view)
    {
//        dd(\Carbon\Carbon::now()->subDays(7));
        $stats = Order::where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get([
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as value')
            ])
            ->toJSON();
        return $view->with('stats', $stats);
    }
}