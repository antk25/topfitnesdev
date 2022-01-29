<?php

namespace App\Exports;

use App\Models\Bracelet;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class BraceletExport implements FromCollection, WithStrictNullComparison, Responsable, WithMapping, WithHeadings
{
    use Exportable;

    private $fileName = "bracelets.xlsx";

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Bracelet::with('grades', 'brand')->first();
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
            'brand',
            'position',
            'plus',
            'minus',
            'buyers_like',
            'popular',
            'year',
            'compatibility',
            'assistant_app',
            'material',
            'replaceable_strap',
            'lenght_adj',
            'colors',
            'protect_stand',
            'terms_of_use',
            'dimensions',
            'weight',
            'disp_diag',
            'disp_tech',
            'disp_resolution',
            'disp_ppi',
            'disp_sens',
            'disp_color',
            'disp_brightness',
            'disp_col_depth',
            'disp_aod',
            'sensors',
            'gps',
            'vibration',
            'blue_ver',
            'nfc',
            'nfc_inf',
            'other_interfaces',
            'phone_calls',
            'notification',
            'send_messages',
            'monitoring',
            'heart_rate',
            'blood_oxy',
            'blood_pressure',
            'training_modes',
            'workout_recognition',
            'inactivity_reminder',
            'search_smartphone',
            'smart_alarm',
            'camera_control',
            'player_control',
            'timer',
            'stopwatch',
            'women_calendar',
            'weather_forecast',
            'additional_info',
            'type_battery',
            'capacity_battery',
            'standby_time',
            'real_time',
            'full_charge_time',
            'charger',
            'destination',
            'func',
            'disp_eval',
            'autonom',
            'design',
            'easy_of_use',
        ];
    }

    public function map($bracelet): array
    {
      return [
        $bracelet->id,
        $bracelet->name,
        $bracelet->slug,
        $bracelet->title,
        $bracelet->subtitle,
        $bracelet->description,
        $bracelet->about,
        $bracelet->brand->name,
        $bracelet->position,
        implode("|", $bracelet->plus),
        implode("|", $bracelet->minus),
        implode("|", $bracelet->buyers_like),
        $bracelet->popular,
        $bracelet->year,
        implode("|", $bracelet->compatibility),
        $bracelet->assistant_app,
        implode("|", $bracelet->material),
        $bracelet->replaceable_strap,
        $bracelet->lenght_adj,
        implode("|", $bracelet->colors),
        implode("|", $bracelet->protect_stand),
        implode("|", $bracelet->terms_of_use),
        $bracelet->dimensions,
        $bracelet->weight,
        $bracelet->disp_diag,
        $bracelet->disp_tech,
        $bracelet->disp_resolution,
        $bracelet->disp_ppi,
        $bracelet->disp_sens,
        $bracelet->disp_color,
        $bracelet->disp_brightness,
        $bracelet->disp_col_depth,
        $bracelet->disp_aod,
        implode("|", $bracelet->sensors),
        $bracelet->gps,
        $bracelet->vibration,
        $bracelet->blue_ver,
        $bracelet->nfc,
        $bracelet->nfc_inf,
        implode("|", $bracelet->other_interfaces),
        $bracelet->phone_calls,
        implode("|", $bracelet->notification),
        $bracelet->send_messages,
        implode("|", $bracelet->monitoring),
        $bracelet->heart_rate,
        $bracelet->blood_oxy,
        $bracelet->blood_pressure,
        implode("|", $bracelet->training_modes),
        $bracelet->workout_recognition,
        $bracelet->inactivity_reminder,
        $bracelet->search_smartphone,
        $bracelet->smart_alarm,
        $bracelet->camera_control,
        $bracelet->player_control,
        $bracelet->timer,
        $bracelet->stopwatch,
        $bracelet->women_calendar,
        $bracelet->weather_forecast,
        $bracelet->additional_info,
        $bracelet->type_battery,
        $bracelet->capacity_battery,
        $bracelet->standby_time,
        $bracelet->real_time,
        $bracelet->full_charge_time,
        $bracelet->charger,
        implode("|", $bracelet->destination),
        $bracelet->grades->pluck('pivot')->where('grade_id', 1)->pluck('value')->implode(','),
        $bracelet->grades->pluck('pivot')->where('grade_id', 2)->pluck('value')->implode(','),
        $bracelet->grades->pluck('pivot')->where('grade_id', 3)->pluck('value')->implode(','),
        $bracelet->grades->pluck('pivot')->where('grade_id', 4)->pluck('value')->implode(','),
        $bracelet->grades->pluck('pivot')->where('grade_id', 5)->pluck('value')->implode(','),
      ];
    }
}
