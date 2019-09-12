<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::truncate();
      User::create([
          'email' => 'santi_shy@hotmail.com',
          'password' => bcrypt('san10mar'),
          'name' => 'Santiago',
      ]);
    }
}
