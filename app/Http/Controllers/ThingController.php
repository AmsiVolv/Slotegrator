<?php

namespace App\Http\Controllers;


use App\Models\Prizes;
use App\Models\PrizeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ThingController extends Controller
{
    /**
     * Удаление последнего полученого элемента
     * Да, возможно, имело бы смысл записывать предмет в прищы лишь после нажатия определенной кнопки
     * чтобы не добавлять и потом удалять
     *
     * А нельзя было раньше эту идею сгенерировать?
     */
    public function rejectItem()
    {
         DB::table('prizes')
            ->leftJoin('prize_types', 'prize_types.id', 'prizes.prize_type_id')
            ->where([
                ['type', '=', 'thing'],
                ['user_id', '=', Auth::id()],
            ])->latest()->delete();
         $this->updateQuantity();
         return redirect()->route('home')->with(['status'=>'Success reject!']);
    }

    /**
     *Очень глупая функция. Сейчас уже понимаю, что можно все изменить
     * Но не сильно есть время
     * Но на это лучше не смотреть
     *
     * @return void
     */
    private function updateQuantity():void
    {
        if(PrizeType::all()->where('type','=', 'thing')->sum('active') !== 0){
            DB::table('prize_types')
                ->where('type', 'thing')
                ->increment('count', 1);
        }else{
            DB::table('prize_types')
                ->where('type', 'thing')
                ->update(['active' => 1, 'count' => 1]);
        }
    }
}
