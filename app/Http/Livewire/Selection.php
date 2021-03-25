<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Bracelet;
use App\ResourceFiltering\QueryFilters;
use App\ResourceFiltering\ProductFilters\ProuctFiltersPreset;

class Selection extends Component
{
    public $search, $disp_tech, $heart_rate, $blood_oxy, $blood_pressure, $smart_alarm, $gps, $disp_sens, $nfc, $min_rating, $protect_stand, $minPrice, $maxPrice, $brand, $budget, $step;

    protected $queryString = [
        'step'
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


    public function render(ProuctFiltersPreset $preset)

    {
        $search = $this->search;
        $brand = $this->brand;
        $disp_tech = $this->disp_tech;
        $heart_rate = $this->heart_rate;
        $blood_oxy = $this->blood_oxy;
        $blood_pressure = $this->blood_pressure;
        $smart_alarm = $this->smart_alarm;
        $gps = $this->gps;
        $disp_sens = $this->disp_sens;
        $protect_stand = $this->protect_stand;
        $nfc = $this->nfc;
        $min_rating = $this->min_rating;
        $minPrice = $this->minPrice;
        $maxPrice = $this->maxPrice;
        $budget = $this->budget;

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
               $minPrice = 10000; 
               $maxPrice = 100000;
            break;

            default:
                # code...
                break;
        }



        if ($protect_stand == 'middle') {
            
            $protect_stand = 'IP67';
        
        }
        elseif ($protect_stand == 'high') {
            
            $protect_stand = [
                'WR50'
            ];

        }
        
        else {
        
            $protect_stand = '';
        
        }

        $bracelets = Bracelet::with('sellers', 'media', 'brands')->where('selection', 1)->filter($preset->getForMarketingMenu($search, $disp_tech, $heart_rate, $blood_oxy, $blood_pressure, $smart_alarm, $gps, $disp_sens, $nfc, $min_rating, $protect_stand, $minPrice, $maxPrice, $brand))->get();

        return view('livewire.selection', compact('bracelets'));

    }
}
