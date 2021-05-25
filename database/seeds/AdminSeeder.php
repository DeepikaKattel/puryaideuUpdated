<?php


use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'role' => '1',
            'email' => 'admin@puryaideu.com',
            'email_verified_at' => now(),
            'gender' => '2',
            'dob' => '1995-05-10',
            'contact1' => '9812321331',
            'city' => 'Kathmandu',
            'area' => 'Kirtipur',
            'password' => bcrypt('puryaideu@@12'),
            'approved_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
