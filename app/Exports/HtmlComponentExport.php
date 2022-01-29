<?php

namespace App\Exports;

use App\Models\HtmlComponent;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HtmlComponentExport implements FromCollection, Responsable, WithMapping, WithHeadings
{
    use Exportable;

    private $fileName = "htmlcomponents.xlsx";

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return HtmlComponent::all();
    }

    public function headings(): array
    {
        return [
            '#',
            'name',
            'link',
            'code',
            'about',
        ];
    }

    public function map($htmlComponent): array
    {
      return [
        $htmlComponent->id,
        $htmlComponent->name,
        $htmlComponent->link,
        $htmlComponent->code,
        $htmlComponent->about,
      ];
    }
}
