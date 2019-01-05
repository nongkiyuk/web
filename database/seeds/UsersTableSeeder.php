<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(App\Models\User::class, 10)->create();
        $user = new User([
            'name' => 'Maful Prayoga',
            'email' => 'maful@example.com',
            'username' => 'mafulful',
            'password' => '123456',
            'is_active' => '1'
        ]);
        $user->save();
        
    }
}
