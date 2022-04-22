<?php

namespace App\Filters\Selection;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletDopFuncFilter extends AbstractEloquentFilter
{
    protected $disp_aod;
    protected $heart_rate;
    protected $blood_pressure;
    protected $smart_alarm;
    protected $gps;
    protected $blood_oxy;
    protected $nfc;
    protected $stress;
    protected $player_control;
    protected $send_messages;

    public function __construct($disp_aod, $heart_rate, $blood_pressure, $smart_alarm, $gps, $blood_oxy, $nfc, $send_messages, $stress, $player_control)
    {
        $this->heart_rate = $heart_rate;
        $this->disp_aod = $disp_aod;
        $this->blood_oxy = $blood_oxy;
        $this->blood_pressure = $blood_pressure;
        $this->smart_alarm = $smart_alarm;
        $this->gps = $gps;
        $this->nfc = $nfc;
        $this->stress = $stress;
        $this->player_control = $player_control;
        $this->send_messages = $send_messages;
    }

    public function apply(Builder $builder): Builder
    {
      return $builder
        ->when($this->disp_aod, function ($builder) {
            $builder->where('disp_aod', $this->disp_aod);
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
        ->when($this->stress, function ($builder) {
            $builder->where('stress', '!=', '');
        })
        ->when($this->player_control, function ($builder) {
            $builder->where('player_control', '!=', '');
        })
        ->when($this->send_messages, function ($builder) {
            $builder->where('send_messages', $this->send_messages);
        });
    }
}
