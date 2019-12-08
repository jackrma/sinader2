<?php

namespace App\Imports;

use App\MonthWaste;
use Maatwebsite\Excel\Concerns\ToModel;

class MonthWasteImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MonthWaste([
            //
        ]);
    }
}
