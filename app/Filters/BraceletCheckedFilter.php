<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletCheckedFilter extends AbstractEloquentFilter
{
    protected $disp_tech;
    protected $heart_rate;
    protected $blood_pressure;
    protected $smart_alarm;
    protected $gps;
    protected $blood_oxy;
    protected $nfc;
    protected $country;

    public function __construct($disp_tech, $heart_rate, $blood_pressure, $smart_alarm, $gps, $blood_oxy, $nfc, $country)
    {
        $this->heart_rate = $heart_rate;
        $this->disp_tech = $disp_tech;
        $this->blood_oxy = $blood_oxy;
        $this->blood_pressure = $blood_pressure;
        $this->smart_alarm = $smart_alarm;
        $this->gps = $gps;
        $this->nfc = $nfc;
        $this->country = $country;
    }

    public function apply(Builder $builder): Builder
    {
      return $builder
        ->when($this->disp_tech, function ($builder) {
            $builder->where('disp_tech', $this->disp_tech);
        })
        ->when($this->heart_rate, function ($builder) {
            $builder->where('heart_rate', $this->heart_rate);
        })
        ->when($this->blood_pressure, function ($builder) {
            $builder->where('blood_pressure', $this->blood_pressure);
        })
        ->when($this->smart_alarm, function ($builder) {
            $builder->where('smart_alarm', $this->smart_alarm);
        })
        ->when($this->gps, function ($builder) {
            $builder->where('gps', $this->gps);
        })
        ->when($this->blood_oxy, function ($builder) {
            $builder->where('blood_oxy', $this->blood_oxy);
        })
        ->when($this->nfc, function ($builder) {
            $builder->where('nfc', '!=', '');
        })
        ->when($this->country, function ($builder) {
            $builder->where('country', $this->country);
        });
    }
}
