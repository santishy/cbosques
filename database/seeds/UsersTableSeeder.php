<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Quotation;
use Illuminate\Support\Facades\DB;
use App\Role;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Role::truncate();
      Quotation::truncate();
      User::truncate();
      DB::table('role_user')->truncate();
      $user = User::create([
          'email' => 'santi_shy@hotmail.com',
          'password' => bcrypt('san10mar'),
          'name' => 'Santiago',
      ]);
      $admin = Role::create(['name' => 'admin','display_name'=>'Administrador del sitio','description'=>'Administra todo el sitio']);
      $user->roles()->save($admin);
      $cotizador = Role::create(['name' => 'cotizador','display_name'=>'Crea cotizaciones','description'=>'Crea cotizaciones para los autorizadores.']);
      $user = User::create([
          'email' => 'santiagomartinochoaestrada@gmail.com',
          'password' => bcrypt('san10mar'),
          'name' => 'Santiago',
      ]);
      $user->roles()->save($cotizador);
      $user = User::create([
          'email' => 'autorizador@gmail.com',
          'password' => bcrypt('san10mar'),
          'name' => 'Santiago',
      ]);
      $role = Role::create(['name' => 'autorizador','display_name'=>'Autoriza las cotizaciones','description'=>'Autoriza las cotizaciones, puede cambiar su status a rechazado o aceptado.']);
      $user->roles()->save($role);
    }
}
