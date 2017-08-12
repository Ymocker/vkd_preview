<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'currnom' => '0',
			'newnom' => '0',
			'kolvo' => '4',
			'ksdelimiter' => ';',
			'smallpic' => '200'
        ]);
    }
}
