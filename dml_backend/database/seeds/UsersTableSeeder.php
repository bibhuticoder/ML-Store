<?php
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
  /**
     * Run the database seeds.
     *
     * @return void
     */
  public function run()
  {
    DB::table('users')->insert([
      'email' => 'user@user.com',
      'password' => bcrypt('password'),
      'credits' => 1000,
      'role' => 0
    ]);
  }
}