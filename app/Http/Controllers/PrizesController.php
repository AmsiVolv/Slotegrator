<?php

namespace App\Http\Controllers;

use App\Models\Prizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrizesController extends Controller
{
    public function loadToDB($id, $amount)
    {
        $prize = new Prizes();
        $prize->prize_type_id=$id;
        $prize->amount=$amount;
        $prize->user_id=Auth::id();
        $prize->save();
    }
}
