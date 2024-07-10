<?php

namespace App\Imports;

use App\Models\HrAccount;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class HrSettingImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new HrAccount([

            'id' => $row['id'],
            'name'     => $row['name'],
            'code'     => $row['code'],
            'account_id'    => $row['account_id'],
            'account_second_id'    => $row['account_second_id'],
            'type'    => $row['type'],
            'created_at'    => $row['created_at'],
            'updated_at'    => $row['updated_at'],

        ]);
    }
}
