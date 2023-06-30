<?php

namespace App\Imports;

use App\Models\UserEmail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class UserEmailImport implements ToModel
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        return new UserEmail([
            'email'     => $row[0],
            'code'    => $row[1],
        ]);
    }
}
