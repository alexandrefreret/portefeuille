<?php

namespace App\Models;

use Deiucanta\Smart\Field;
use Deiucanta\Smart\Model;

class Account extends Model
{
    public function fields()
    {
        return [
            Field::make('id')->increments(),
        ];
    }
}