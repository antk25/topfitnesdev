<?php

namespace App\Http\Livewire\Product;

use App\Filters\BraceletBrandFilter;
use App\Filters\BraceletCheckedFilter;
use App\Filters\BraceletJsonFieldsFilter;
use App\Filters\BraceletPriceRangeFilter;
use App\Filters\NameFilter;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Bracelet;
use App\Models\Brand;
use Pricecurrent\LaravelEloquentFilters\EloquentFilters;

class Bracelets extends Component
{
    use WithPagination;

    public $name, $disp_tech, $blood_oxy, $blood_pressure, $smart_alarm, $gps, $nfc, $min_rating, $protect_stand, $max_price, $brand, $country, $compatibility;

    public $page = 1;

    public $heart_rate = false;

    public function clearFilter($namefilter)
    {

        $this->$namefilter = '';

    }

    public function updating() {

        $this->resetPage();

    }

    protected $queryString = [
        'heart_rate' => ['except' => false],
        'blood_oxy' => ['except' => false],
        'blood_pressure' => ['except' => false],
        'smart_alarm' => ['except' => false],
        'gps' => ['except' => false],
        'nfc' => ['except' => ''],
        'brand' => ['except' => ''],
        'disp_tech' => ['except' => ''],
        'protect_stand' => ['except' => ''],
        'max_price' => ['except' => ''],
        'min_rating' => ['except' => ''],
        'country' => ['except' => ''],
        'compatibility' => ['except' => ''],
    ];

    // protected $queryString = ['heart_rate', 'disp_tech', 'protect_stand', 'max_price', 'min_price', 'blood_oxy', 'blood_pressure', 'smart_alarm', 'gps', 'disp_sens', 'nfc', 'brand'];


    public function render()
    {
        $brand = $this->brand;
        $name = $this->name;
        $disp_tech = $this->disp_tech;
        $heart_rate = $this->heart_rate;
        $blood_oxy = $this->blood_oxy;
        $blood_pressure = $this->blood_pressure;
        $smart_alarm = $this->smart_alarm;
        $gps = $this->gps;
        $protect_stand = $this->protect_stand;
        $nfc = $this->nfc;
        $min_rating = $this->min_rating;
        $max_price = $this->max_price;
        $country = $this->country;
        $compatibility = $this->compatibility;

        $filters = EloquentFilters::make([
                                          new BraceletBrandFilter($brand),
                                          new NameFilter($name),
                                        //   new BraceletCheckedFilter($disp_tech, $heart_rate, $blood_pressure, $smart_alarm, $gps, $blood_oxy, $nfc, $country),
                                        //   new BraceletJsonFieldsFilter($protect_stand, $compatibility),
                                        //   new BraceletPriceRangeFilter($max_price)
                                        ]);


        $bracelets = Bracelet::with('sellers', 'media', 'brands')->filter($filters)->paginate(15);

        $brands = Brand::pluck('id', 'name')->all();


        return view('livewire.bracelets', compact('bracelets', 'brands'));
    }
}
