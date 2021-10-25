<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;
use App\ResourceFiltering\QueryFilters;
use Spatie\Image\Image;


class Bracelet extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

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
        return $this->belongsToMany(Grade::class)->withPivot('position', 'value');
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

    public function setMaterialAttribute($value)
    {
        $this->attributes['material'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    }

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

    public function setColorsAttribute($value)
    {
        $this->attributes['colors'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function setProtectStandAttribute($value)
    {
        $this->attributes['protect_stand'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function setTermsOfUseAttribute($value)
    {
        $this->attributes['terms_of_use'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function setSensorsAttribute($value)
    {
        $this->attributes['sensors'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function setOtherInterfacesAttribute($value)
    {
        $this->attributes['other_interfaces'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function setMonitoringAttribute($value)
    {
        $this->attributes['monitoring'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function setTrainingModesAttribute($value)
    {
        $this->attributes['training_modes'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
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


    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }

}
