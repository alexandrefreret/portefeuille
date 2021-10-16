<?php

namespace App\Models;
use App\Models\AbstractModel;

use Deiucanta\Smart\Field;
use Deiucanta\Smart\Model;

class Account extends AbstractModel
{
    public $table = "account";
    public $primaryKey = "account_id";

    
    public function fields()
    {
        $fields = parent::fields();

        $fields[] = Field::make('account_name')->string();
        $fields[] = Field::make('account_fees')->decimal(10, 2);
        $fields[] = Field::make('account_type')->string();
        $fields[] = Field::make('user')->belongsTo($this);


        return $fields;
    }

    static public function hasUser()
    {
        return true;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'account_user', 'id');
    }

    public function pair() {
        
        return $this->hasOne('App\Models\Pair');
    }
}
