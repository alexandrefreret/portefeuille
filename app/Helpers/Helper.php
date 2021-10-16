<?php 
namespace App\Helpers;
class Helper 
{
	public static function floordec($zahl,$decimals=2){   
		return floor($zahl*pow(10,$decimals))/pow(10,$decimals);
   }
}