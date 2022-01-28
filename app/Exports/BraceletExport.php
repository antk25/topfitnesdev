<?php

namespace App\Exports;

use App\Models\Bracelet;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class BraceletExport implements FromCollection, WithStrictNullComparison, Responsable, WithMapping
{
    use Exportable;

    private $fileName = "bracelets.xlsx";

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Bracelet::with('grades')->get();
    }

    public function map($bracelet): array
    {
      return [
        $bracelet->id,
        $bracelet->name,
        $bracelet->title,
        $bracelet->grades,
        $bracelet->grades->pluck('pivot')->where('grade_id', 1)->pluck('value')->implode(', '),
        $bracelet->grades->pluck('pivot')->where('grade_id', 2)->pluck('value')->implode(', '),
        $bracelet->grades->pluck('pivot')->where('grade_id', 3)->pluck('value')->implode(', '),
        $bracelet->grades->pluck('pivot')->where('grade_id', 4)->pluck('value')->implode(', '),
        $bracelet->grades->where('id', 1)->pluck('pivot')->first(),
        $bracelet->grades->where('id', 1)->pluck('name')->first(),
      ];
    }
}
