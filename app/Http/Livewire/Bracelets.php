<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Bracelet;
use App\Models\Brand;
use App\ResourceFiltering\QueryFilters;
use App\ResourceFiltering\ProductFilters\ProductSearchFilter;
use App\ResourceFiltering\ProductFilters\ProuctFiltersPreset;
use App\ResourceFiltering\ProductFilters\ProductMinRatingsFilter;
use App\ResourceFiltering\ProductFilters\ProductPriceRangeFilter;

class Bracelets extends Component
{
    use WithPagination;

    public $search, $disp_tech, $heart_rate, $blood_oxy, $blood_pressure, $smart_alarm, $gps, $disp_sens, $nfc, $min_rating, $protect_stand, $min_price, $max_price, $brand;

    public function clearFilter($namefilter)
    {
        
        $this->$namefilter = '';
        
    }

    protected $queryString = ['heart_rate', 'disp_tech', 'protect_stand', 'max_price', 'min_price', 'blood_oxy', 'blood_pressure', 'smart_alarm', 'gps', 'disp_sens', 'nfc', 'brand'];


    public function render(ProuctFiltersPreset $preset)
    {
        // dd($this->protect_stand);
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
        $min_price = $this->min_price;
        $max_price = $this->max_price;
        // dd($protect_stand);
        if ($protect_stand == 'middle') {
            
            $protect_stand = 'IP57';
        
        }
        elseif ($protect_stand == 'high') {
            
            $protect_stand = [
                'IP68',
                'WR50'
            ];

        }
        
        else {
        
            $protect_stand = '';
        
        }

        $bracelets = Bracelet::with('sellers', 'media', 'brands')->filter($preset->getForMarketingMenu($search, $disp_tech, $heart_rate, $blood_oxy, $blood_pressure, $smart_alarm, $gps, $disp_sens, $nfc, $min_rating, $protect_stand, $min_price, $max_price, $brand))->paginate(15);
        $brands = Brand::pluck('id', 'name')->all();
        return view('livewire.bracelets', compact('bracelets', 'brands'));
        $this->emit('loadData');
    }
}
