<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pair;
use App\Models\Trades;

class TradesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the list of pair.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function all()
    {
		$pairs = Pair::get();
		
        return view('trades.pair', ['pairs' => $pairs]);
    }

    /**
     * Show the detail of pair.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function detail(Request $request, $id)
    {
		$trades = Trades::where('trades_pair', $id)
			->orderBy('trades_id', 'desc')
			->get();

		return view('trades.detail', ['trades' => $trades]);
	}
}
