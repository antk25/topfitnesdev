<?php

namespace App\Http\Livewire\Product;

use App\Filters\BraceletBrandFilter;
use App\Filters\BraceletCheckedFilter;
use App\Filters\BraceletJsonFieldsFilter;
use App\Filters\BraceletPriceRangeFilter;
use App\Filters\MinRatingsFilter;
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

    public $name, $disp_aod, $blood_oxy,
        $blood_pressure, $smart_alarm,
        $gps, $nfc, $min_rating, $protect_stand,
        $maxPrice, $minPrice, $brand, $send_messages, $compatibility, $destination, $player_control, $stress, $heart_rate;

    public $page = 1;

    public function clearFilter($namefilter)
    {
        $this->$namefilter = null;
    }

    public function clearAllFilter()
    {
        $this->reset();
    }

    public function updating()
    {
        $this->resetPage();
    }

    protected $queryString = [
        'heart_rate' => ['except' => false],
        'blood_oxy' => ['except' => false],
        'blood_pressure' => ['except' => false],
        'smart_alarm' => ['except' => false],
        'gps' => ['except' => false],
        'nfc' => ['except' => false],
        'brand' => ['except' => ''],
        'disp_aod' => ['except' => false],
        'protect_stand' => ['except' => ''],
        'maxPrice' => ['except' => ''],
        'min_rating' => ['except' => ''],
        'compatibility' => ['except' => ''],
        'destination' => ['except' => ''],
        'player_control' => ['except' => false],
        'stress' => ['except' => false],
        'send_messages' => ['except' => false],
    ];

    // protected $queryString = ['heart_rate', 'disp_tech', 'protect_stand', 'max$maxPrice', 'min_price', 'blood_oxy', 'blood_pressure', 'smart_alarm', 'gps', 'disp_sens', 'nfc', 'brand'];


    public function render()
    {
        $brand = $this->brand;
        $name = $this->name;
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
        $min_rating = $this->min_rating;
        $maxPrice = $this->maxPrice;
        $minPrice = $this->minPrice;
        $send_messages = $this->send_messages;
        $compatibility = $this->compatibility;
        $destination = $this->destination;

        $filters = EloquentFilters::make([
                                          new BraceletBrandFilter($brand),
                                          new NameFilter($name),
                                          new MinRatingsFilter($min_rating),
                                          new BraceletCheckedFilter($disp_aod, $heart_rate, $blood_pressure, $smart_alarm, $gps, $blood_oxy, $nfc, $send_messages, $stress, $player_control),
                                          new BraceletJsonFieldsFilter($protect_stand, $compatibility, $destination),
                                          new BraceletPriceRangeFilter($maxPrice, $minPrice)
                                        ]);


        $bracelets = Bracelet::filter($filters)->with('sellers', 'media', 'brand')->paginate(15);

        $brands = Brand::whereIn('name', ['Xiaomi','Honor','Huawei','Redmi','Samsung','Garmin','Realme','Oppo','Fitbit'])->pluck('id', 'name')->all();


        return view('livewire.bracelets', compact('bracelets', 'brands'));
    }
}
