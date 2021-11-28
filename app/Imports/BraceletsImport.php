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
use Maatwebsite\Excel\Row;
use Throwable;

class BraceletsImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    SkipsOnFailure

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
            // 'position' => $row['position'],
            'plus' => explode("|", $row['plus']),
            'minus' => explode("|", $row['minus']),
            'buyers_like' => explode("|", $row['buyers_like']),
            // 'popular' => $row['popular'],
            // 'year' => $row['year'],
            // 'country' => $row['country'],
            // 'compatibility' => $row['compatibility'],
            // 'assistant_app' => $row['assistant_app'],
            // 'material' => explode("|", $row['material']),
            // 'replaceable_strap' => $row['replaceable_strap'],
            // 'lenght_adj' => $row['lenght_adj'],
            // 'colors' => explode("|", $row['colors']),
            // 'protect_stand' => explode("|", $row['protect_stand']),
            // 'terms_of_use' => explode("|", $row['terms_of_use']),
            // 'dimensions' => $row['dimensions'],
            // 'weight' => $row['weight'],
            // 'disp_diag' => $row['disp_diag'],
            // 'disp_tech' => $row['disp_techdisp_resolution'],
            // 'disp_resolution' => $row['disp_resolution'],
            // 'disp_ppi' => $row['disp_ppi'],
            // 'disp_sens' => $row['disp_sens'],
            // 'disp_color' => $row['disp_color'],
            // 'disp_brightness' => $row['disp_brightness'],
            // 'disp_col_depth' => $row['disp_col_depth'],
            // 'disp_aod' => $row['disp_aod'],
            // 'sensors' => explode("|", $row['sensors']),
            // 'gps' => $row['gps'],
            // 'vibration' => $row['vibration'],
            // 'blue_ver' => $row['blue_ver'],
            // 'nfc' => $row['nfc'],
            // 'other_interfaces' => explode("|", $row['other_interfaces']),
            // 'phone_calls' => $row['phone_calls'],
            // 'notification' => $row['notification'],
            // 'send_messages' => $row['send_messages'],
            // 'monitoring' => explode("|", $row['monitoring']),
            // 'heart_rate' => $row['heart_rate'],
            // 'blood_oxy' => $row['blood_oxy'],
            // 'blood_pressure' => $row['blood_pressure'],
            // 'stress' => $row['stress'],
            // 'training_modes' => explode("|", $row['training_modes']),
            // 'workout_recognition' => $row['workout_recognition'],
            // 'inactivity_reminder' => $row['inactivity_reminder'],
            // 'search_smartphone' => $row['search_smartphone'],
            // 'smart_alarm' => $row['smart_alarm'],
            // 'camera_control' => $row['camera_control'],
            // 'player_control' => $row['player_control'],
            // 'timer' => $row['timer'],
            // 'stopwatch' => $row['stopwatch'],
            // 'women_calendar' => $row['women_calendar'],
            // 'weather_forecast' => $row['weather_forecast'],
            // 'additional_info' => $row['additional_info'],
            // 'type_battery' => $row['type_battery'],
            // 'capacity_battery' => $row['capacity_battery'],
            // 'standby_time' => $row['standby_time'],
            // 'real_time' => $row['real_time'],
            // 'full_charge_time' => $row['full_charge_time'],
            // 'charger' => $row['charger']
            // 'popular' => $row['popular']
        ]);


        $files = $row['files'];
            if ($files != '') {
                if (Str::contains($files, '|')) {
                    $files = explode("|", $files);
                    foreach ($files as $file) {
                        $bracelet->addMedia($file)
                            ->preservingOriginal()
                            ->toMediaCollection('bracelet');
                    }

                }
            else  {
                    $bracelet->addMedia($files)
                        ->preservingOriginal()
                        ->toMediaCollection('bracelet');
            }
        }

        return $bracelet;
    }




    /**
     * Валидация значений из файла
     *
     * В правило Rule передаем парметры валидации
     *
     * Подробнее тут https://laravel.com/api/8.x/Illuminate/Validation/Rule.html
     *
     **/

    public function rules(): array
    {
        return [
            '*.name' => Rule::unique('bracelets', 'name'),
            '*.slug' => Rule::unique('bracelets', 'slug'),
        ];
    }
}
