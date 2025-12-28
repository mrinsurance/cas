<?php

namespace App\Exports;

use App\open_new_ac_model;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportBalanceBook implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return open_new_ac_model::all();
    }
}
