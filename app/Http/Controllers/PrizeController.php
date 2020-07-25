<?php
declare (strict_types=1);


namespace App\Http\Controllers;
use App\Models\Thing;
use Faker\Generator;
use App\Models\Prizes;
use App\Models\PrizeType;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    protected $amount = 0;

    public function game(Generator $fake){
        $prize = $this->getRandomPrize();
        if($prize['type'] !== 'thing')
        {
            $available = $prize['count'];
            $amount =  $fake->numberBetween($available/15+1, $available/10);
            return view('winpage', ['prize'=>$prize['type'], 'amount'=>$amount]);
        }else{
            $prize = $this->getRandomItem();
            return view('winpage', ['prize'=>$prize['name'], 'amount'=>1]);
        }
    }

    /**
     * Function to get a random prize from DB
     * @return array
     */
    public function getRandomPrize()
    {
        return PrizeType::all()->where('count', '>',0)->random()->toArray();
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
