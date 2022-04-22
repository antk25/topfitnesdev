<?php

namespace App\Http\Livewire\Filter;

use Livewire\Component;
use App\Models\Bracelet;
use App\Models\Spec;
use App\Filters\Selection\BraceletCompatibilityFilter;
use App\Filters\Selection\BraceletDestinationFilter;
use App\Filters\Selection\BraceletDispColorFilter;
use App\Filters\Selection\BraceletDispDpiFilter;
use App\Filters\Selection\BraceletDispSizeFilter;
use App\Filters\Selection\BraceletDopFuncFilter;
use App\Filters\Selection\BraceletPriceFilter;
use App\Filters\Selection\BraceletProtectFilter;
use Pricecurrent\LaravelEloquentFilters\EloquentFilters;

class Selection extends Component
{
    public $minPrice, $maxPrice, $step, $budget, $compatibility, $protect_stand, $selectedDestination = [];

    public $disp_aod, $blood_oxy, $blood_pressure, $smart_alarm, $gps, $nfc, $send_messages, $player_control, $stress, $heart_rate;

    public $dispSize, $minDispSize, $maxDispSize, $dispColor, $dispDpi, $minDispDpi, $maxDispDpi;

    public $protect;

    protected $queryString = [
        'step',
        'budget',
        'compatibility',
        'protect_stand',
        'selectedDestination',
        'dispSize',
        'dispColor',
        'dispDpi',
        'protect',
    ];

    public function mount()
    {
        $this->step = 1;
    }

    public function nextStep()
    {
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function goStep($numberStep)
    {
        $this->step = $numberStep;
    }


    public function render()

    {
        $minPrice = $this->minPrice;
        $maxPrice = $this->maxPrice;
        $budget = $this->budget;
        $compatibility = $this->compatibility;
        $protect_stand = $this->protect_stand;
        $selectedDestination = $this->selectedDestination;
        $disp_aod = $this->disp_aod;
        $heart_rate = $this->heart_rate;
        $blood_oxy = $this->blood_oxy;
        $blood_pressure = $this->blood_pressure;
        $smart_alarm = $this->smart_alarm;
        $gps = $this->gps;
        $protect_stand = $this->protect_stand;
        $nfc = $this->nfc;
        $player_control = $this->player_control;
        $stress = $this->stress;
        $send_messages = $this->send_messages;
        $minDispSize = $this->minDispSize;
        $maxDispSize = $this->maxDispSize;
        $dispSize = $this->dispSize;
        $dispColor = $this->dispColor;
        $dispDpi = $this->dispDpi;
        $minDispDpi = $this->minDispDpi;
        $maxDispDpi = $this->maxDispDpi;
        $protect = $this->protect;

        switch ($budget) {
            case 'low':
               $maxPrice = 3000;
               $minPrice = 100;
            break;

            case 'middle':
               $maxPrice = 6000;
               $minPrice = 3000;
            break;

            case 'high':
               $maxPrice = 10000;
               $minPrice = 6000;
            break;

            case 'premium':
               $maxPrice = 100000;
               $minPrice = 10000;
            break;

            default:
               $maxPrice = 100000;
               $minPrice = 0;
                break;
        }

        switch ($dispSize) {
            case 'little':
                $minDispSize = 0;
                $maxDispSize = 0.5;
                break;
            case 'medium':
                $minDispSize = 0.5;
                $maxDispSize = 1.0;
                break;
            case 'big':
                $minDispSize = 1.0;
                $maxDispSize = 10;
                break;

            default:
                # code...
                break;
        }
        if ($dispColor == 'color') {
           $dispColor = true;
        }
        else {
            $dispColor = false;
        }
        switch ($dispDpi) {
            case 'low':
                $minDispDpi = 0;
                $maxDispDpi = 150;
                break;
            case 'middle':
                $minDispDpi = 150;
                $maxDispDpi = 190;
                break;
            case 'high':
                $minDispDpi = 190;
                $maxDispDpi = 1000;
                break;

            default:
                # code...
                break;
        }

        $filters = EloquentFilters::make([
            // new MinRatingsFilter($min_rating),
            new BraceletDopFuncFilter($disp_aod, $heart_rate, $blood_pressure, $smart_alarm, $gps, $blood_oxy, $nfc, $send_messages, $stress, $player_control),
            new BraceletCompatibilityFilter($compatibility),
            new BraceletPriceFilter($minPrice, $maxPrice),
            new BraceletDestinationFilter($selectedDestination),
            new BraceletDispSizeFilter($minDispSize, $maxDispSize),
            new BraceletDispColorFilter($dispColor),
            new BraceletDispDpiFilter($minDispDpi, $maxDispDpi),
            new BraceletProtectFilter($protect),
          ]);

        $bracelets = Bracelet::filter($filters)->where('selection', 1)->with('sellers', 'media', 'brand')->get();

        $dest = collect(Spec::where('name', 'destination')->pluck('value'))->all();

        // $destination = $destination->toArray();

        return view('livewire.selection', compact('bracelets', 'dest'));

    }
}
