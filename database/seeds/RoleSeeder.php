<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(array(
            array(
                'role' => 'admin',
            ),
            array(

                'role' => 'rider',
            ),
            array(

                'role' => 'customer',
            ),
            array(

                'role' => 'driver',
            )

        ));
    }
}
