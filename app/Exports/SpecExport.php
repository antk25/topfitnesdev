<?php

namespace App\Exports;

use App\Models\Spec;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SpecExport implements FromCollection, Responsable, WithMapping, WithHeadings
{
    use Exportable;

    private $fileName = "specs.xlsx";

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Spec::all();
    }

    public function headings(): array
    {
        return [
            '#',
            'name',
            'device',
            'value',
        ];
    }

    public function map($spec): array
    {
      return [
        $spec->id,
        $spec->name,
        $spec->device,
        $spec->value,
      ];
    }
}
