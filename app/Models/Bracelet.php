<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bracelet extends Model
{
    protected $fillable = [
        'published',
        'title',
        'subtitle',
        'description',
        'position',
        'country',
        'notification',
        'vibration',
        'disp_tech',
        'year',
        'material',
        'year',
        'length_adj',
        'ppi',
        'monitoring',
        'replaceable_strap',
        'protect_stand',
        'diagonal',
        'resolution',
        'color_disp',
        'sensory',
        'smart_alarm',
        'blood_pressure',
        'heart_rate',
        'blood_oxy',
        'camera_control',
        'player_control',
        'gps',
        'sensors',
        'capacity_battery',
        'standby_time',
        'model',
        'slug',
        'brand_id',
        'name',
        'compatibility',
        'assistant_app'
    ];

    protected $casts = [
        'material' => 'array',
        'notification' => 'array',
        'monitoring' => 'array',
        'sensors' => 'array',
        'resolution' => 'array',
    ];

    // Связываем с Рейтингами

    public function ratings() {
        return $this->belongsToMany(Rating::class)->withPivot('position');
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

    // protected function asJson($value)
    // {
    //     return json_encode($value, JSON_UNESCAPED_UNICODE);
    // }
}
