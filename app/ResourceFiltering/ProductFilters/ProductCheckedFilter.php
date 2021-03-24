<?php

namespace App\ResourceFiltering\ProductFilters;

use App\ResourceFiltering\QueryFilterContract;

class ProductCheckedFilter implements QueryFilterContract
{
    protected $disp_tech;
    protected $disp_sens;
    protected $heart_rate;
    protected $blood_pressure;
    protected $smart_alarm;
    protected $gps;
    protected $blood_oxy;
    protected $nfc;

    public function __construct($disp_tech, $heart_rate, $blood_oxy, $blood_pressure, $smart_alarm, $gps, $disp_sens, $nfc)
    {
        $this->heart_rate = $heart_rate;
        $this->disp_tech = $disp_tech;
        $this->disp_sens = $disp_sens;
        $this->blood_oxy = $blood_oxy;
        $this->blood_pressure = $blood_pressure;
        $this->smart_alarm = $smart_alarm;
        $this->gps = $gps;
        $this->nfc = $nfc;
    }

    public function apply($query)
    {
        // dd($this->terms_of_use);
        $query
        ->when($this->disp_tech, function ($query) {
            $query->where('disp_tech', $this->disp_tech);
        })
        ->when($this->heart_rate, function ($query) {
            $query->where('heart_rate', $this->heart_rate);
        })
        ->when($this->disp_sens, function ($query) {
            $query->where('disp_sens', $this->disp_sens);
        })
        ->when($this->blood_pressure, function ($query) {
            $query->where('blood_pressure', $this->blood_pressure);
        })
        ->when($this->smart_alarm, function ($query) {
            $query->where('smart_alarm', $this->smart_alarm);
        })
        ->when($this->gps, function ($query) {
            $query->where('gps', $this->gps);
        })
        ->when($this->blood_oxy, function ($query) {
            $query->where('blood_oxy', $this->blood_oxy);
        })
        ->when($this->nfc, function ($query) {
            $query->where('nfc', '!=', '');
        });
    }

    // public function shouldRun()
    // {
        // return (bool) $this->value;
    // }
}
