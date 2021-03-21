<?php

namespace App\Imports;

use App\Models\Bracelet;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class BraceletsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $bracelet = Bracelet::create([
            'name' => $row['name'],
            'slug' => $row['slug'],
            'title' => $row['title'],
            'subtitle' => $row['subtitle'],
            'description' => $row['description'],
            'about' => $row['about'],
            'brand_id' => $row['brand_id'],
            'position' => $row['position'],
            'plus' => explode("|", $row['plus']),
            'minus' => explode("|", $row['minus']),
            'buyers_like' => explode("|", $row['buyers_like']),
            'popular' => $row['popular'],
            'year' => $row['year'],
            'country' => $row['country'],
            'compatibility' => $row['compatibility'],
            'assistant_app' => $row['assistant_app'],
            'material' => explode("|", $row['material']),
            'replaceable_strap' => $row['replaceable_strap'],
            'lenght_adj' => $row['lenght_adj'],
            'colors' => explode("|", $row['colors']),
            'protect_stand' => explode("|", $row['protect_stand']),
            'terms_of_use' => explode("|", $row['terms_of_use']),
            'dimensions' => $row['dimensions'],
            'weight' => $row['weight'],
            'disp_diag' => $row['disp_diag'],
            'disp_tech' => $row['disp_techdisp_resolution'],
            'disp_resolution' => $row['disp_resolution'],
            'disp_ppi' => $row['disp_ppi'],
            'disp_sens' => $row['disp_sens'],
            'disp_color' => $row['disp_color'],
            'disp_brightness' => $row['disp_brightness'],
            'disp_col_depth' => $row['disp_col_depth'],
            'disp_aod' => $row['disp_aod'],
            'sensors' => explode("|", $row['sensors']),
            'gps' => $row['gps'],
            'vibration' => $row['vibration'],
            'blue_ver' => $row['blue_ver'],
            'nfc' => $row['nfc'],
            'other_interfaces' => explode("|", $row['other_interfaces']),
            'phone_calls' => $row['phone_calls'],
            'notification' => $row['notification'],
            'send_messages' => $row['send_messages'],
            'monitoring' => explode("|", $row['monitoring']),
            'heart_rate' => $row['heart_rate'],
            'blood_oxy' => $row['blood_oxy'],
            'blood_pressure' => $row['blood_pressure'],
            'stress' => $row['stress'],
            'training_modes' => explode("|", $row['training_modes']),
            'workout_recognition' => $row['workout_recognition'],
            'inactivity_reminder' => $row['inactivity_reminder'],
            'search_smartphone' => $row['search_smartphone'],
            'smart_alarm' => $row['smart_alarm'],
            'camera_control' => $row['camera_control'],
            'player_control' => $row['player_control'],
            'timer' => $row['timer'],
            'stopwatch' => $row['stopwatch'],
            'women_calendar' => $row['women_calendar'],
            'weather_forecast' => $row['weather_forecast'],
            'additional_info' => $row['additional_info'],
            'type_battery' => $row['type_battery'],
            'capacity_battery' => $row['capacity_battery'],
            'standby_time' => $row['standby_time'],
            'real_time' => $row['real_time'],
            'full_charge_time' => $row['full_charge_time'],
            'charger' => $row['charger'],
            'popular' => $row['popular'],
        ]);
        
        
        $files = $row['files'];
        // dd($files);
       if ($files != '') {
        if (Str::contains($files, '|')) {
            $files = explode("|", $files);
            $lastbracelet = Bracelet::find($bracelet->id);
            foreach ($files as $file) {
                $lastbracelet->addMedia($file)
                    ->preservingOriginal()
                    ->toMediaCollection('bracelet');
            }
            
        }
        else  {
            $lastbracelet = Bracelet::find($bracelet->id);
                $lastbracelet->addMedia($files)
                    ->preservingOriginal()
                    ->toMediaCollection('bracelet');
        }
    }
}
}
