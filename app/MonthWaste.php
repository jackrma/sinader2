<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class MonthWaste extends Model
{
	
    protected $table = 'month_wastes';
    use Importable;

    protected $guarded = [];

}
