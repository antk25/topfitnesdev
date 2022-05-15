<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletCheckedFilter extends AbstractEloquentFilter
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

    public function apply(Builder $query): Builder
    {
      return $query
        ->when($this->disp_aod, function ($query) {
            $query->where('disp_aod', $this->disp_aod);
        })
        ->when($this->heart_rate, function ($query) {
            $query->where('heart_rate', $this->heart_rate);
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
        })
        ->when($this->stress, function ($query) {
            $query->where('stress', '!=', '');
        })
        ->when($this->player_control, function ($query) {
            $query->where('player_control', '!=', '');
        })
        ->when($this->send_messages, function ($query) {
            $query->where('send_messages', $this->send_messages);
        });
    }
}
