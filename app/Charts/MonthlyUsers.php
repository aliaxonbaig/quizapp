<?php

declare(strict_types=1);

namespace App\Charts;

use Carbon\Carbon;
use App\Models\User;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\BaseChart;

class MonthlyUsers extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $userData = User::selectRaw('DATE(created_at) as x, COUNT(*) as y')
            ->groupBy('x')
            ->where('created_at', '>', Carbon::now()->subWeek())
            ->get();
        // dd($userData);
        $dates = [];
        $usercount = [];
        foreach ($userData as $data) {
            array_push($dates, $data->x);
            array_push($usercount, $data->y);
        }
        return Chartisan::build()
            ->labels($dates)
            ->dataset('Site Users Per Day', $usercount);
    }
}
