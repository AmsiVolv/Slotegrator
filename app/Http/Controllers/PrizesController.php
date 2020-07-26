<?php

namespace App\Http\Controllers;

use App\Models\Prizes;
use App\Models\PrizeType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrizesController extends Controller
{
    public function loadToDB($id, $amount)
    {
        $prize = new Prizes();
        $prize->prize_type_id = $id;
        $prize->amount = $amount;
        $prize->user_id = Auth::id();
        $prize->save();
    }

    /**
     * Функция, которая вернет массив с результатми всех игр
     * @return array
     */
    public function summaryStats()
    {
        $reward = [];
        foreach ($this->getAllPrizeTypes() as $item) {
            $points = DB::table('prizes')->where([
                    ['prize_type_id', '=', $item['id']],
                    ['user_id', '=', Auth::id()],
                ])
                ->get()->sum('amount');

            array_push($reward, [
                    'type' => $item['type'],
                    'quantity' => $points
                ]);
        }
        return $reward;
    }

    /**
     * Да, возможно отдельная функция лишняя.
     * @return array
     */
    private function getAllPrizeTypes()
    {
        return (PrizeType::all()->toArray());
    }
}
