<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public static $seeders = [];

    public function run()
    {
        $this->call(self::$seeders);
    }
}
