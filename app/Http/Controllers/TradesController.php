<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pair;
use App\Models\Trades;
use App\Helpers\Helper;

use App\Services\BinanceService;

use Illuminate\Support\Facades\Validator;

class TradesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BinanceService $binanceService)
    {
        $this->binanceService = $binanceService;
    }

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
		$pair = Pair::find($id);
		if(!$pair)
		{
			return abort(404);
		}

		$trades = Trades::where('trades_pair', $id)
			->orderBy('trades_id', 'desc')
			->get();

		return view('trades.detail', ['trades' => $trades, 'pair' => $pair]);
	}

    /**
     * Delete a trade
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id)
    {
		$trade = Trades::find($id);
		
		if(!$trade)
		{
			return abort(404);
		}
		
		$trade->trades_valide = 0;
		$trade->save();
		return redirect()->route('trades/detail', ['id' => $trade->trades_pair]);
	}

    /**
     * Add a trade
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'pair_id' => 'required',
            'qte' => 'required',
            'price' => 'required',
            'direction' => 'required',
        ]);
        
		$datas = $request->all();
        echo '<pre>'; var_dump($datas); echo'</pre>';
        if ($validator->fails()) {

			return redirect()->route('trades/detail', ['id' => $datas['pair_id']])->withErrors($validator)
			->withInput();
        }
        
        
		$pair = Pair::find($datas['pair_id']);
        $account = $pair->account()->first();
        
		$last_trade = Trades::where('trades_pair', $datas['pair_id'])
			->orderBy('trades_id', 'DESC')
			->first();
		
		if($account->account_type == "percentage")
		{
			$amount_of_devise = $datas["qte"] / $datas["price"];
			if($amount_of_devise > 1)
            {
                $amount_of_devise = Helper::floordec($amount_of_devise, 2);
            }

            if($datas["direction"] == "1")
            {
                echo '<pre>'; var_dump($amount_of_devise); echo'</pre>';
                $pru = $datas["price"] + ($amount_of_devise * $account->account_fees);
                echo '<pre>'; var_dump($pru); echo'</pre>';
            }
            else {
                echo '<pre>'; var_dump($amount_of_devise); echo'</pre>';
                $pru = $datas["price"] + ($datas["qte"] * $account->account_fees);
                echo '<pre>'; var_dump($pru); echo'</pre>';
            }

            if(!$last_trade)
            {
                
            }

		}
		else
		{
			
		}
	}

    public function binance(Request $request)
    {
        //https://github.com/jaggedsoft/php-binance-api/tree/master/examples
        $endpoint = "https://api.binance.com";

        $all_orders_api = "/api/v3/allOrders";
        $result = $this->binanceService->CallAPI("GET", $endpoint . $all_orders_api);
        

        echo '<pre>'; var_dump($result); echo'</pre>';
    }
}
