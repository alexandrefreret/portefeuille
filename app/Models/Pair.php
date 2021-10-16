<?php

namespace App\Models;

use App\Models\AbstractModel;

use Deiucanta\Smart\Field;
use Deiucanta\Smart\Model;

class Pair extends AbstractModel
{
    public $table = "pair";
    public $primaryKey = "pair_id";

    public function fields()
    {
        $fields = parent::fields();

        $fields[] = Field::make('pair_name')->string();
        $fields[] = Field::make('pair_position')->string(); //Permet de choisir si position long terme, court terme
        $fields[] = Field::make('user')->belongsTo($this);
        $fields[] = Field::make('account')->belongsTo($this);


        return $fields;
    }

    static public function hasUser()
    {
        return true;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'pair_user', 'id');
    }


    public function account()
    {
        return $this->belongsTo('App\Models\Account', 'pair_account', 'account_id');
    }
}
