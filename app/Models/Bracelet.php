<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;
use App\ResourceFiltering\QueryFilters;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Image\Image;


/**
 * App\Models\Bracelet
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string|null $subtitle
 * @property string|null $description
 * @property string|null $about
 * @property int $brand_id
 * @property int|null $position
 * @property float|null $rating_bracelet
 * @property float|null $grade_bracelet
 * @property array|null $plus
 * @property array|null $minus
 * @property array|null $buyers_like
 * @property int|null $popular
 * @property int|null $hit
 * @property int|null $selection
 * @property string|null $assistant_app
 * @property int|null $year
 * @property string|null $country
 * @property array|null $material
 * @property int|null $replaceable_strap
 * @property int|null $lenght_adj
 * @property array|null $colors
 * @property array|null $protect_stand
 * @property array|null $terms_of_use
 * @property string|null $dimensions
 * @property float|null $weight
 * @property float|null $disp_diag
 * @property string|null $disp_tech
 * @property string|null $disp_resolution
 * @property int|null $disp_ppi
 * @property int|null $disp_sens
 * @property int|null $disp_color
 * @property int|null $disp_brightness
 * @property int|null $disp_col_depth
 * @property int|null $disp_aod
 * @property array|null $sensors
 * @property int|null $gps
 * @property int|null $vibration
 * @property float|null $blue_ver
 * @property string|null $nfc
 * @property array|null $other_interfaces
 * @property string|null $phone_calls
 * @property string|null $notification
 * @property string|null $send_messages
 * @property array|null $monitoring
 * @property int|null $heart_rate
 * @property int|null $blood_oxy
 * @property int|null $blood_pressure
 * @property int|null $stress
 * @property array|null $training_modes
 * @property int|null $workout_recognition
 * @property int|null $inactivity_reminder
 * @property int|null $search_smartphone
 * @property int|null $smart_alarm
 * @property int|null $camera_control
 * @property int|null $player_control
 * @property int|null $timer
 * @property int|null $stopwatch
 * @property int|null $women_calendar
 * @property int|null $weather_forecast
 * @property string|null $additional_info
 * @property string|null $type_battery
 * @property int|null $capacity_battery
 * @property int|null $standby_time
 * @property string|null $real_time
 * @property int|null $full_charge_time
 * @property string|null $charger
 * @property int $published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $avg_price
 * @property array|null $compatibility
 * @property-read \App\Models\Brand $brands
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CompareItem[] $compareitem
 * @property-read int|null $compareitem_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comparison[] $comparison
 * @property-read int|null $comparison_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Grade[] $grades
 * @property-read int|null $grades_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Overview|null $overview
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rating[] $ratings
 * @property-read int|null $ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Seller[] $sellers
 * @property-read int|null $sellers_count
 * @method static Builder|Bracelet filter(\App\ResourceFiltering\QueryFilters $filters)
 * @method static Builder|Bracelet newModelQuery()
 * @method static Builder|Bracelet newQuery()
 * @method static Builder|Bracelet query()
 * @method static Builder|Bracelet whereAbout($value)
 * @method static Builder|Bracelet whereAdditionalInfo($value)
 * @method static Builder|Bracelet whereAssistantApp($value)
 * @method static Builder|Bracelet whereAvgPrice($value)
 * @method static Builder|Bracelet whereBloodOxy($value)
 * @method static Builder|Bracelet whereBloodPressure($value)
 * @method static Builder|Bracelet whereBlueVer($value)
 * @method static Builder|Bracelet whereBrandId($value)
 * @method static Builder|Bracelet whereBuyersLike($value)
 * @method static Builder|Bracelet whereCameraControl($value)
 * @method static Builder|Bracelet whereCapacityBattery($value)
 * @method static Builder|Bracelet whereCharger($value)
 * @method static Builder|Bracelet whereColors($value)
 * @method static Builder|Bracelet whereCompatibility($value)
 * @method static Builder|Bracelet whereCountry($value)
 * @method static Builder|Bracelet whereCreatedAt($value)
 * @method static Builder|Bracelet whereDescription($value)
 * @method static Builder|Bracelet whereDimensions($value)
 * @method static Builder|Bracelet whereDispAod($value)
 * @method static Builder|Bracelet whereDispBrightness($value)
 * @method static Builder|Bracelet whereDispColDepth($value)
 * @method static Builder|Bracelet whereDispColor($value)
 * @method static Builder|Bracelet whereDispDiag($value)
 * @method static Builder|Bracelet whereDispPpi($value)
 * @method static Builder|Bracelet whereDispResolution($value)
 * @method static Builder|Bracelet whereDispSens($value)
 * @method static Builder|Bracelet whereDispTech($value)
 * @method static Builder|Bracelet whereFullChargeTime($value)
 * @method static Builder|Bracelet whereGps($value)
 * @method static Builder|Bracelet whereGradeBracelet($value)
 * @method static Builder|Bracelet whereHeartRate($value)
 * @method static Builder|Bracelet whereHit($value)
 * @method static Builder|Bracelet whereId($value)
 * @method static Builder|Bracelet whereInactivityReminder($value)
 * @method static Builder|Bracelet whereLenghtAdj($value)
 * @method static Builder|Bracelet whereMaterial($value)
 * @method static Builder|Bracelet whereMinus($value)
 * @method static Builder|Bracelet whereMonitoring($value)
 * @method static Builder|Bracelet whereName($value)
 * @method static Builder|Bracelet whereNfc($value)
 * @method static Builder|Bracelet whereNotification($value)
 * @method static Builder|Bracelet whereOtherInterfaces($value)
 * @method static Builder|Bracelet wherePhoneCalls($value)
 * @method static Builder|Bracelet wherePlayerControl($value)
 * @method static Builder|Bracelet wherePlus($value)
 * @method static Builder|Bracelet wherePopular($value)
 * @method static Builder|Bracelet wherePosition($value)
 * @method static Builder|Bracelet whereProtectStand($value)
 * @method static Builder|Bracelet wherePublished($value)
 * @method static Builder|Bracelet whereRatingBracelet($value)
 * @method static Builder|Bracelet whereRealTime($value)
 * @method static Builder|Bracelet whereReplaceableStrap($value)
 * @method static Builder|Bracelet whereSearchSmartphone($value)
 * @method static Builder|Bracelet whereSelection($value)
 * @method static Builder|Bracelet whereSendMessages($value)
 * @method static Builder|Bracelet whereSensors($value)
 * @method static Builder|Bracelet whereSlug($value)
 * @method static Builder|Bracelet whereSmartAlarm($value)
 * @method static Builder|Bracelet whereStandbyTime($value)
 * @method static Builder|Bracelet whereStopwatch($value)
 * @method static Builder|Bracelet whereStress($value)
 * @method static Builder|Bracelet whereSubtitle($value)
 * @method static Builder|Bracelet whereTermsOfUse($value)
 * @method static Builder|Bracelet whereTimer($value)
 * @method static Builder|Bracelet whereTitle($value)
 * @method static Builder|Bracelet whereTrainingModes($value)
 * @method static Builder|Bracelet whereTypeBattery($value)
 * @method static Builder|Bracelet whereUpdatedAt($value)
 * @method static Builder|Bracelet whereVibration($value)
 * @method static Builder|Bracelet whereWeatherForecast($value)
 * @method static Builder|Bracelet whereWeight($value)
 * @method static Builder|Bracelet whereWomenCalendar($value)
 * @method static Builder|Bracelet whereWorkoutRecognition($value)
 * @method static Builder|Bracelet whereYear($value)
 * @mixin \Eloquent
 */
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
        'compatibility' => 'array',
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

    // public function setCompatibilityAttribute($value)
    // {
    //     $this->attributes['compatibility'] = collect($value)->filter()->values()->toJson(JSON_UNESCAPED_UNICODE);
    // }

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
