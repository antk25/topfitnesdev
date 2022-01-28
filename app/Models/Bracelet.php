<?php

namespace App\Models;

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
           'weight',
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

    public function ratings(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Rating::class)->withPivot('position', 'text_rating', 'head_rating');
    }

//    public function reviews()
//    {
//        return $this->hasMany(Review::class);
//    }

    /**
     * Связываем с отзывами
     */
    public function reviews(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    // Связываем с брендами

    public function brands(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    // Связываем с обзором

    public function overview(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Overview::class);
    }

    // Связываем с мануалами

    public function manuals(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Manual::class);
    }

    // Связываем с сравнениями

    public function comparisons(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Comparison::class);
    }

    // Связываем с оценками

    public function grades(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Grade::class)->withPivot('value');
    }

    // Связываем с продавцами

    public function sellers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Seller::class)->withPivot('link', 'price', 'old_price');
    }

    // Связь с статьями-сравнениями

    public function comparison(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Comparison::class);
    }

    // Связь с таблицей CompareItems

    public function compareitem(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(CompareItem::class);
    }

    // 3. Функция от админки для получения уже имеющихся атрибутов из БД и отметка соответствующих флажков https://twill.io/docs/#multiselect-with-static-values
    // public function getMaterialAttribute($value)
    // {
    //     return collect(json_decode($value))->map(function($item) {
    //         return ['id' => $item];
    //     })->all();
    // }
    //
    // protected function asJson($value)
    // {
    //     return json_encode($value, JSON_UNESCAPED_UNICODE);
    // }

    // public function setPlusAttribute($value)
    // {
    //     $this->attributes['plus'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    // }
    //
    // public function setMinusAttribute($value)
    // {
    //     $this->attributes['minus'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    // }
    //
    // public function setBuyersLikeAttribute($value)
    // {
    //     $this->attributes['buyers_like'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    // }


    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
        ->crop('crop-center', 400, 400);
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
