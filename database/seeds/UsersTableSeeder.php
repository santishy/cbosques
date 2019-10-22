<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Quotation;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Quotation::truncate();
      // User::truncate();
      $user = User::create([
          'email' => 'santi_shy@hotmail.com',
          'password' => bcrypt('san10mar'),
          'name' => 'Santiago',
      ]);
      $user->roles()->attach(1);
    }
}
