<?php

namespace App\Imports;

use App\Models\Bracelet;
use App\Models\Brand;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Row;
use Throwable;

class BraceletsImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnError,
    // WithValidation,
    SkipsOnFailure,
    WithUpserts
    // WithUpsertColumns

{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * Конструктор для выборки всех брендов, чтобы при парсинге не использовать множество запросов к таблице Brands
     *
     * Подробнее в видео:
     *
     * https://www.youtube.com/watch?v=n2WOag1G7Zg
     */

    private $brands;

    public function __construct()
    {

        $this->brands = Brand::select('id', 'name')->get();

    }

    /**
     * @param array $row
     *
     * Иcпользуем метод Collection для создания моделей отношения
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        /**
         * Записываем в переменную $brand найденный объект класса Brand по полю name
         * https://www.youtube.com/watch?v=n2WOag1G7Zg
         */

        $brand = $this->brands->where('name', $row['brand'])->first();

        $bracelet = new Bracelet([
            'name' => $row['name'],
            'slug' => $row['slug'],
            'title' => $row['title'],
            'subtitle' => $row['subtitle'],
            'description' => $row['description'],
            'about' => $row['about'],
            'brand_id' => $brand->id ?? NULL,
            'position' => $row['position'],
            'plus' => $row['plus'] ? explode("|", $row['plus']) : [],
            'minus' => $row['minus'] ? explode("|", $row['minus']) : [],
            'buyers_like' => $row['buyers_like'] ? explode("|", $row['buyers_like']) : [],
            'popular' => $row['popular'] ? true : false,
            'year' => $row['year'],
            'country' => $row['country'],
            'compatibility' => $row['compatibility'] ? explode("|", $row['compatibility']) : [],
            'assistant_app' => $row['assistant_app'],
            'material' =>  $row['material'] ? explode("|", $row['material']) : [],
            'replaceable_strap' => $row['replaceable_strap'] ? true : false,
            'lenght_adj' => $row['lenght_adj'] ? true : false,
            'colors' => $row['colors'] ? explode("|", $row['colors']) : [],
            'protect_stand' => $row['protect_stand'] ? explode("|", $row['protect_stand']) : [],
            'terms_of_use' => $row['terms_of_use'] ? explode("|", $row['terms_of_use']) : [],
            'dimensions' => $row['dimensions'],
            'weight' => $row['weight'],
            'disp_diag' => $row['disp_diag'],
            'disp_tech' => $row['disp_techdisp_resolution'],
            'disp_resolution' => $row['disp_resolution'],
            'disp_ppi' => $row['disp_ppi'],
            'disp_sens' => $row['disp_sens'] ? true : false,
            'disp_color' => $row['disp_color'] ? true : false,
            'disp_brightness' => $row['disp_brightness'],
            'disp_col_depth' => $row['disp_col_depth'],
            'disp_aod' => $row['disp_aod'] ? true : false,
            'sensors' => $row['sensors'] ? explode("|", $row['sensors']) : [],
            'gps' => $row['gps'] ? true : false,
            'vibration' => $row['vibration'] ? true : false,
            'blue_ver' => $row['blue_ver'],
            'nfc' => $row['nfc'] ? true : false,
            'nfc_inf' => $row['nfc_inf'],
            'other_interfaces' => $row['other_interfaces'] ? explode("|", $row['other_interfaces']) : [],
            'phone_calls' => $row['phone_calls'],
            'notification' =>  $row['notification'] ? explode("|", $row['notification']) : [],
            'send_messages' => $row['send_messages'] ? true : false,
            'monitoring' => $row['monitoring'] ? explode("|", $row['monitoring']) : [],
            'heart_rate' => $row['heart_rate'] ? true : false,
            'blood_oxy' => $row['blood_oxy'] ? true : false,
            'blood_pressure' => $row['blood_pressure'] ? true : false,
            'stress' => $row['stress'] ? true : false,
            'training_modes' => $row['training_modes'] ? explode("|", $row['training_modes']) : [],
            'workout_recognition' => $row['workout_recognition'] ? true : false,
            'inactivity_reminder' => $row['inactivity_reminder'] ? true : false,
            'search_smartphone' => $row['search_smartphone'] ? true : false,
            'smart_alarm' => $row['smart_alarm'] ? true : false,
            'camera_control' => $row['camera_control'] ? true : false,
            'player_control' => $row['player_control'] ? true : false,
            'timer' => $row['timer'] ? true : false,
            'stopwatch' => $row['stopwatch'] ? true : false,
            'women_calendar' => $row['women_calendar'],
            'weather_forecast' => $row['weather_forecast'],
            'additional_info' => $row['additional_info'],
            'type_battery' => $row['type_battery'],
            'capacity_battery' => $row['capacity_battery'],
            'standby_time' => $row['standby_time'],
            'real_time' => $row['real_time'],
            'full_charge_time' => $row['full_charge_time'],
            'charger' => $row['charger'],
            'destination' => $row['destination'] ? explode("|", $row['destination']) : [],
        ]);


        // $files = $row['files'];
        //     if ($files != '') {
        //         if (Str::contains($files, '|')) {
        //             $files = explode("|", $files);
        //             foreach ($files as $file) {
        //                 $bracelet->addMedia($file)
        //                     ->preservingOriginal()
        //                     ->toMediaCollection('bracelet');
        //             }

        //         }
        //     else  {
        //             $bracelet->addMedia($files)
        //                 ->preservingOriginal()
        //                 ->toMediaCollection('bracelet');
        //     }
        // }

        return $bracelet;
    }

    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'name';
    }

    /**
     * @return array
     */
    // public function upsertColumns()
    // {
    //     return ['about'];
    // }




    /**
     * Валидация значений из файла
     *
     * В правило Rule передаем парметры валидации
     *
     * Подробнее тут https://laravel.com/api/8.x/Illuminate/Validation/Rule.html
     *
     **/

    // public function rules(): array
    // {
    //     return [
    //         '*.name' => Rule::unique('bracelets', 'name'),
    //         '*.slug' => Rule::unique('bracelets', 'slug'),
    //     ];
    // }
}
