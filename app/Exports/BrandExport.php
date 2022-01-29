<?php

namespace App\Exports;

use App\Models\Brand;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BrandExport implements FromCollection, Responsable, WithMapping, WithHeadings
{
    use Exportable;

    private $fileName = "brands.xlsx";

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Brand::all();
    }

    public function headings(): array
    {
        return [
            '#',
            'name',
            'slug',
            'title',
            'subtitle',
            'description',
            'about',
        ];
    }

    public function map($brand): array
    {
      return [
        $brand->id,
        $brand->name,
        $brand->slug,
        $brand->title,
        $brand->subtitle,
        $brand->description,
        $brand->about,
      ];
    }
}
