<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::table('roles')->delete();
        DB::table('roles')->insert([
            [
                'id' => 1,
                'role_name' => 'admin'
            ],
            [
                'id' => 2,
                'role_name' => 'supervusor'
            ],
            [
                'id' => 3,
                'role_name' => 'executive'
            ],
        ]);

    }
}
