<?php

namespace App\Services;

class BinanceService
{
	public $api_url = "https://api.binance.com";
	// $apikey = "PAxNAzKRg1L8GFuhMhHNExz6HPG1EawQ2wb780SvQKRSlTxnWuyY1fdEenkgNif4";
	// $secret_key = "asogPZOVg4euKIdJx66KPxtCvHcZlslK5TEd5Lesrr89H4Xe32bg7SbTmVgI1eXC";
	function CallAPI($method, $url, $data = false)
	{
		return file_get_contents($this->api_url . $url);
	}

	function calc_avg($elems)
	{
		return array_sum($elems)/count($elems);
	}
}