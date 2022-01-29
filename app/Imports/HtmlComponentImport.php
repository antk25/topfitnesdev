<?php

namespace App\Imports;

use App\Models\HtmlComponent;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class HtmlComponentImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnError,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $htmlcomponent = HtmlComponent::create([
           'name' => $row['name'],
           'link' => $row['link'],
           'code' => $row['code'],
           'about' => $row['about'],
        ]);

        return $htmlcomponent;
    }
}
