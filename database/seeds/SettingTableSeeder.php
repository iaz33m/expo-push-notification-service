<?php

use Illuminate\Database\Seeder;

use App\Setting;
use Carbon\Carbon;


class SettingTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){

        $settings = [
            ['name'=>'Example Setting Name','key' => 'exapmle_key','value' => 'Example Value'],
        ];

        foreach ($settings as $setting){
            Setting::create($setting);
        }

    }
}
