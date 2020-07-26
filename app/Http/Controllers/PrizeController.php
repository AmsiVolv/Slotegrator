<?php
declare (strict_types=1);


namespace App\Http\Controllers;

use App\Models\PrizeType;
use App\Models\Thing;
use Faker\Generator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class PrizeController extends Controller
{
    protected $amount = 0;

    public function game(Generator $fake)
    {
        $prize = $this->getRandomPrize();
        return $this->checkThePrise($prize, $fake);
    }

    /**
     * Function to get a random prize from DB
     * @return array
     */
    public function getRandomPrize()
    {
        return PrizeType::all()->where('count', '>', 0)->random()->toArray();
    }

    /**
     * Check prize type function
     * @param array $prizeArray
     * @param Generator $fake
     * @return Factory|View
     */
    private function checkThePrise(Array $prizeArray, Generator $fake)
    {
        if ($prizeArray['type'] !== 'thing') {
            return $this->pointMoneyCheck($prizeArray, $fake);
        } else {
            return $this->quantityCheck($prizeArray, 1);
        }
    }

    /**
     * Генерируем тут циферку и пусть себе хорошо живет, если че она заправляет тем насколько тебе везет
     * (мне не везет)
     *
     *
     * @param array $prize
     * @param Generator $fake
     * @return Factory|View
     */
    private function pointMoneyCheck(Array $prize, Generator $fake)
    {
        $amount = $fake->numberBetween($prize['count'] / 15 + 1, $prize['count'] / 10 + 1);
        return $this->quantityCheck($prize, $amount);
    }

    /**
     * Ну тут все просто
     * Если еще система позволяет крутить казино - крутись
     * Нет - получай бонусики, так как active=0
     *
     * Знал бы прикуп, жил бы в Сочи
     *
     * @param array $prizeArray
     * @param Int $amount
     * @return Factory|View
     */
    public function quantityCheck(Array $prizeArray, Int $amount)
    {
        if ($prizeArray['type'] !== 'points') {
            if ($prizeArray['count'] - $amount === 0) {
                DB::table('prize_types')
                    ->where('id', $prizeArray['id'])
                    ->update(['active' => 0, 'count' => 0]);
            } else {
                DB::table('prize_types')
                    ->where('id', $prizeArray['id'])
                    ->update(['count' => $prizeArray['count'] - $amount]);
            }
        }
        return $this->insertToDB($prizeArray, $amount);
    }

    /**
     * Поздравим с победой бонусов, ведь вещей больше нет
     * Функция запишет твою победу в ДБ
     * Вернет  тебя на страницу победитель
     *
     * @param $prizeArray
     * @param Int $amount
     * @return Factory|View
     */
    private function insertToDB($prizeArray, Int $amount)
    {
        $prize = new PrizesController();
        $prize->loadToDB($prizeArray['id'], $amount);
        return view('winpage', ['prize' => $prizeArray['type'], 'amount' => $amount, 'prize_id' => $prizeArray['id']]);
    }

    /**
     * Function to get a random item from DB
     * @return array
     */
    public function getRandomItem()
    {
        return Thing::all()->where('status', '=', 1)->random()->toArray();
    }
}
