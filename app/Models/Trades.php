<?php

namespace App\Models;

use App\Models\AbstractModel;

use Deiucanta\Smart\Field;
use Deiucanta\Smart\Model;

class Trades extends AbstractModel
{
    public $table = "trades";
    public $primaryKey = "trades_id";

    public $fillable = [
        "trades_pair",
    ];

    public function fields()
    {
        $fields = parent::fields();

        $fields[] = Field::make('trades_price')->decimal(14, 8); // en $
        $fields[] = Field::make('trades_qte')->decimal(14, 8); // en $
        $fields[] = Field::make('trades_amount')->decimal(14, 8); // en SOL/MATIC ... (calculé en auto)
        $fields[] = Field::make('trades_fees_amount')->decimal(14, 8);
        $fields[] = Field::make('trades_pru')->decimal(14, 8);
        $fields[] = Field::make('trades_direction')->boolean()->default(1); // 1 => Achat, 0 => Vente
        $fields[] = Field::make('pair')->belongsTo($this);
        $fields[] = Field::make('user')->belongsTo($this);


        return $fields;
    }

    static public function hasUser()
    {
        return true;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'trades_user', 'id');
    }

    public function pair()
    {
        return $this->belongsTo('App\Models\Pair', 'trades_pair', 'pair_id');
    }
}
