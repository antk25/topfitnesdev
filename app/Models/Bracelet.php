<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pricecurrent\LaravelEloquentFilters\Filterable;


class Bracelet extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, Filterable;

    protected $fillable = [
           'name',
           'slug',
           'title',
           'subtitle',
           'description',
           'about',
           'brand_id',
           'position',
           'plus',
           'minus',
           'buyers_like',
           'popular',
           'hit',
           'selection',
           'published',
           'year',
           'country',
           'compatibility',
           'assistant_app',
           'material',
           'replaceable_strap',
           'lenght_adj',
           'colors',
           'protect_stand',
           'terms_of_use',
           'dimensions',
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
           'stress',
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
           'destination'
    ];

    protected $casts = [
        'material' => 'array',
        'monitoring' => 'array',
        'sensors' => 'array',
        'plus' => 'array',
        'minus' => 'array',
        'buyers_like' => 'array',
        'colors' => 'array',
        'protect_stand' => 'array',
        'terms_of_use' => 'array',
        'other_interfaces' => 'array',
        'training_modes' => 'array',
        'compatibility' => 'array',
        'notification' => 'array',
        'destination' => 'array',
    ];

    protected $dates = [
        'deleted_at'
    ];

    // Связываем с Рейтингами

    public function ratings() {
        return $this->belongsToMany(Rating::class)->withPivot('position', 'text_rating', 'head_rating');
    }

    // Связываем с отзывами

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Связываем с брендами

    public function brands() {
        return $this->belongsTo(Brand::class);
    }

    // Связываем с обзором

    public function overview()
    {
        return $this->hasOne(Overview::class);
    }

    // Связываем с оценками

    public function grades() {
        return $this->belongsToMany(Grade::class)->withPivot('value');
    }

    // Связываем с продавцами

    public function sellers() {
        return $this->belongsToMany(Seller::class)->withPivot('link', 'price', 'old_price');
    }

    // Связь с статьями-сравнениями

    public function comparison() {
        return $this->belongsToMany(Comparison::class);
    }

    // Связь с таблицей CompareItems

    public function compareitem() {
        return $this->belongsToMany(CompareItem::class);
    }

    // 3. Функция от админки для получения уже имеющихся атрибутов из БД и отметка соответствующих флажков https://twill.io/docs/#multiselect-with-static-values
    // public function getMaterialAttribute($value)
    // {
    //     return collect(json_decode($value))->map(function($item) {
    //         return ['id' => $item];
    //     })->all();
    // }

    public function setPlusAttribute($value)
    {
        $this->attributes['plus'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function setMinusAttribute($value)
    {
        $this->attributes['minus'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function setBuyersLikeAttribute($value)
    {
        $this->attributes['buyers_like'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    }


    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('320')
            ->width(320);

        $this->addMediaConversion('640')
            ->width(640);

        $this->addMediaConversion('960')
            ->width(960);

        $this->addMediaConversion('1280')
            ->width(1280);

        $this->addMediaConversion('thumb')
        ->crop('crop-center', 300, 300);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');
    }


    // public function scopeFilter($query, QueryFilters $filters)
    // {
    //     return $filters->apply($query);
    // }

}
