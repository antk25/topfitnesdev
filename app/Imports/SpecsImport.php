<?php

namespace App\Imports;

use App\Models\Spec;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class SpecsImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    public function model(array $row)
    {
        // $values = explode("|", $row['value']);
        // $slugs = explode("|", $row['slugs']);
        // $values = array_combine($values, $slugs);

        $spec = Spec::create([
           'name' => $row['name'],
           'device' => $row['device'],
           'value' => json_decode($row['value'], true, 64),
        ]);

        return $spec;
    }


    public function rules(): array
    {
        return [
            '*.name' => Rule::unique('specs', 'name'),
        ];
    }

}