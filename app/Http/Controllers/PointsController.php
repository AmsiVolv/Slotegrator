<?php

namespace App\Http\Controllers;

use App\Models\PrizeType;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;

class PointsController extends Controller
{
    public function convertPoints(Request $req)
    {
        $this->checkAmount($req->post('convert'));
        return redirect()->route('home')->with(['status'=>'Success convert!']);
    }

    /**
     * @param Int $toConvert
     * @param Float $rate
     * @return RedirectResponse|void
     */
    public function checkAmount(Int $toConvert, Float $rate = 0.2)
    {
        $money = $this->getAmount();
        if ($money['count'] - $rate * $toConvert >= 0) {
            DB::table('prizes')
                ->leftJoin('prize_types', 'prize_types.id', 'prizes.prize_type_id')
                ->where([
                    ['type', '=', 'points'],
                    ['user_id', '=', Auth::id()],
                ])->orderBy('prizes.created_at', 'desc')
                ->limit(1)->update([
                    'prizes.prize_type_id' => $money['id'],
                    'prizes.amount' => $rate * $toConvert
                    ]);
              $this->updateMoney($rate * $toConvert);
        } else {
            return redirect()->route('home')->with(['error' => 'Not enough money at system']);
        }
    }

    /**
     * @return mixed
     */
    private function getAmount()
    {
        return PrizeType::all()->where('type', 'money')->first()->toArray();
    }

    /**
     * Функция на обновление денег в главной таблице
     * @param Int $newAmount
     */
    private function updateMoney(Int $newAmount):void
    {
        DB::Table('prize_types')->where('type','=','money')->decrement('count', $newAmount);
    }
}
