<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pair;
use App\Models\Trades;
use App\Helpers\Helper;

use App\Services\BinanceService;

use Illuminate\Support\Facades\Validator;

class ScreenerController extends Controller
{
    public $units = [
        "15m" => "15 minutes",
        "30m" => "30 minutes",
        "1h" => "1 hours",
        "4h" => "4 hours",
        "1d" => "1 days",
        "1w" => "1 weeks",
    ];
    public $pairs = ["BTCUSDT","ETHUSDT","BNBUSDT","BCCUSDT","NEOUSDT","LTCUSDT","QTUMUSDT","ADAUSDT","XRPUSDT","EOSUSDT","TUSDUSDT","IOTAUSDT","XLMUSDT","ONTUSDT",
    "TRXUSDT","ETCUSDT","ICXUSDT","VENUSDT","NULSUSDT","VETUSDT","PAXUSDT","BCHABCUSDT","BCHSVUSDT","USDCUSDT","LINKUSDT","WAVESUSDT","BTTUSDT","USDSUSDT","ONGUSDT",
    "HOTUSDT","ZILUSDT","ZRXUSDT","FETUSDT","BATUSDT","XMRUSDT","ZECUSDT","IOSTUSDT","CELRUSDT","DASHUSDT","NANOUSDT","OMGUSDT","THETAUSDT","ENJUSDT","MITHUSDT","MATICUSDT",
    "ATOMUSDT","TFUELUSDT","ONEUSDT","FTMUSDT","ALGOUSDT","USDSBUSDT","GTOUSDT","ERDUSDT","DOGEUSDT","DUSKUSDT","ANKRUSDT","WINUSDT","COSUSDT","NPXSUSDT","COCOSUSDT","MTLUSDT",
    "TOMOUSDT","PERLUSDT","DENTUSDT","MFTUSDT","KEYUSDT","STORMUSDT","DOCKUSDT","WANUSDT","FUNUSDT","CVCUSDT","CHZUSDT","BANDUSDT","BUSDUSDT","BEAMUSDT","XTZUSDT","RENUSDT","RVNUSDT",
    "HCUSDT","HBARUSDT","NKNUSDT","STXUSDT","KAVAUSDT","ARPAUSDT","IOTXUSDT","RLCUSDT","MCOUSDT","CTXCUSDT","BCHUSDT","TROYUSDT","VITEUSDT","FTTUSDT","EURUSDT","OGNUSDT","DREPUSDT",
    "BULLUSDT","BEARUSDT","ETHBULLUSDT","ETHBEARUSDT","TCTUSDT","WRXUSDT","BTSUSDT","LSKUSDT","BNTUSDT","LTOUSDT","EOSBULLUSDT","EOSBEARUSDT","XRPBULLUSDT","XRPBEARUSDT","STRATUSDT",
    "AIONUSDT","MBLUSDT","COTIUSDT","BNBBULLUSDT","BNBBEARUSDT","STPTUSDT","WTCUSDT","DATAUSDT","XZCUSDT","SOLUSDT","CTSIUSDT","HIVEUSDT","CHRUSDT","GXSUSDT",
    "ARDRUSDT","LENDUSDT","MDTUSDT","STMXUSDT","KNCUSDT","REPUSDT","LRCUSDT","PNTUSDT","COMPUSDT","BKRWUSDT","SCUSDT","ZENUSDT","SNXUSDT","VTHOUSDT","DGBUSDT","GBPUSDT","SXPUSDT","MKRUSDT",
    "DAIUSDT","DCRUSDT","STORJUSDT","MANAUSDT","AUDUSDT","YFIUSDT","BALUSDT","BLZUSDT","IRISUSDT","KMDUSDT","JSTUSDT","SRMUSDT","ANTUSDT","CRVUSDT","SANDUSDT","OCEANUSDT","NMRUSDT",
    "DOTUSDT","LUNAUSDT","RSRUSDT","PAXGUSDT","WNXMUSDT","TRBUSDT",
    "BZRXUSDT","SUSHIUSDT","YFIIUSDT","KSMUSDT","EGLDUSDT","DIAUSDT","RUNEUSDT","FIOUSDT","UMAUSDT","BELUSDT","WINGUSDT","UNIUSDT","NBSUSDT","OXTUSDT","SUNUSDT","AVAXUSDT","HNTUSDT","FLMUSDT",
    "ORNUSDT","UTKUSDT","XVSUSDT","ALPHAUSDT","AAVEUSDT","NEARUSDT","FILUSDT","INJUSDT","AUDIOUSDT","CTKUSDT","AKROUSDT",
    "AXSUSDT","HARDUSDT","DNTUSDT","STRAXUSDT","UNFIUSDT","ROSEUSDT","AVAUSDT","XEMUSDT","SKLUSDT","SUSDUSDT",
    "GRTUSDT","JUVUSDT","PSGUSDT","1INCHUSDT","REEFUSDT","OGUSDT","ATMUSDT","ASRUSDT","CELOUSDT","RIFUSDT","BTCSTUSDT","TRUUSDT","CKBUSDT","TWTUSDT","FIROUSDT","LITUSDT","SFPUSDT","DODOUSDT",
    "CAKEUSDT","ACMUSDT","BADGERUSDT","FISUSDT","OMUSDT","PONDUSDT","DEGOUSDT","ALICEUSDT","LINAUSDT","PERPUSDT","RAMPUSDT","SUPERUSDT","CFXUSDT","EPSUSDT","AUTOUSDT","TKOUSDT","PUNDIXUSDT",
    "TLMUSDT","BTGUSDT","MIRUSDT","BARUSDT","FORTHUSDT","BAKEUSDT","BURGERUSDT","SLPUSDT","SHIBUSDT","ICPUSDT","ARUSDT","POLSUSDT","MDXUSDT","MASKUSDT","LPTUSDT",
    "NUUSDT","XVGUSDT","ATAUSDT","GTCUSDT","TORNUSDT","KEEPUSDT","ERNUSDT","KLAYUSDT","PHAUSDT","BONDUSDT","MLNUSDT","DEXEUSDT","C98USDT","CLVUSDT","QNTUSDT","FLOWUSDT","TVKUSDT","MINAUSDT",
    "RAYUSDT","FARMUSDT","ALPACAUSDT","QUICKUSDT","MBOXUSDT","FORUSDT","REQUSDT","GHSTUSDT","WAXPUSDT","TRIBEUSDT","GNOUSDT","XECUSDT","ELFUSDT","DYDXUSDT","POLYUSDT","IDEXUSDT","VIDTUSDT",
    "USDPUSDT","GALAUSDT","ILVUSDT","YGGUSDT","SYSUSDT","DFUSDT","FIDAUSDT","FRONTUSDT","CVPUSDT","AGLDUSDT","RADUSDT","BETAUSDT","RAREUSDT"];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BinanceService $binanceService)
    {
        $this->binanceService = $binanceService;
    }

    public function index()
    {
        return view('screener.index', ["units" => $this->units]);
    }

    public function search(Request $request)
    {
        set_time_limit(0);

        $validator = Validator::make($request->all(), [
            'units' => 'required',
            'moyenne_1' => 'required',
            'moyenne_2' => 'required',
            'pourcentage' => 'required',
        ]);
        
        if ($validator->fails()) {
			
			return redirect()->route('screener')->withErrors($validator)
			->withInput();
        }
		
		$datas = $validator->validated();

		// $pairs = [];
		// $market = $this->binanceService->CallAPI("GET", "/api/v3/exchangeInfo");
		// $tab = json_decode($market);
		// foreach ($tab->symbols as $key => $value) {
		// 	if($value->quoteAsset == "USDT")
		// 	{
		// 		$pairs[] = $value->symbol;
		// 	}
		// }

        $units = $this->units[$datas["units"]];
        $units_exploded = explode(" ", $units);

        $symbols = [];

        // foreach ($this->pairs as $key => $value)
        // {
        //     $start_time = date("Y-m-d H:i:s", strtotime("-". ($datas["moyenne_2"] * $units_exploded[0]) . " " . $units_exploded[1]));
        //     $price = $this->binanceService->CallAPI("GET", "/api/v3/klines?symbol=" . $value . "&interval=" . $datas["units"] . "&startTime=" . strtotime($start_time) * 1000);
        //     $price = json_decode($price);
        //     $prices = \Arr::pluck($price, "4");
        //     if(!empty($prices))
        //     {
        //         $spliced = array_slice($prices, ($datas["moyenne_2"] - $datas["moyenne_1"]), $datas["moyenne_1"]);
        //         if(count($spliced) == $datas["moyenne_1"])
        //         {
        //             $avg_1 = $this->binanceService->calc_avg($spliced);
        //             $avg_2 = $this->binanceService->calc_avg($prices);
        //             $pourcentage = 100 - (($avg_2 / $avg_1) * 100);
        //             if($pourcentage <= $datas["pourcentage"] && $pourcentage >= -$datas["pourcentage"])
        //             {
        //                 $symbols[] = [
        //                     "symbol" => $value,
        //                     "pourcentage" => $pourcentage,
        //                 ];
        //             }
        //         }
        //     }
        // }

        $symbols = \Arr::sort($symbols, function($value){
            return $value["pourcentage"];
        });
        
        return view('screener.search', ['symbols' => $symbols, "units" => $this->units]);
    }
}
