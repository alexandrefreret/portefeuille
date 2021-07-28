<?php

namespace App\Models;

use Deiucanta\Smart\Field;
use Deiucanta\Smart\Model;

class Pair extends AbstractModel
{
    public $table = "pair";

    public function fields()
    {
        $fields = parent::fields();

        $fields[] = Field::make('pair_name')->string();
        $fields[] = Field::make('pair_position')->string(); //Permet de choisir si position long terme, court terme
        $fields[] = Field::make('user')->belongsTo($this);


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
}
