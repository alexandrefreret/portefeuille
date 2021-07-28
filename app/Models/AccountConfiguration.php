<?php

namespace App\Models;

use Deiucanta\Smart\Field;
use Deiucanta\Smart\Model;

class AccountConfiguration extends AbstractModel
{
    public $table = "account_configuration";

    public function fields()
    {
        $fields = parent::fields();

        $fields[] = Field::make('accountconfiguration_title')->string();
        $fields[] = Field::make('accountconfiguration_fees')->decimal(10, 4);
        $fields[] = Field::make('accountconfiguration_type')->enum(['pourcentage', 'numeraire']);

        return $fields;
    }
}
