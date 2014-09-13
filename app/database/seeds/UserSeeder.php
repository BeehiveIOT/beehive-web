<?php
class UserSeeder extends Seeder {
    public function run() {
        DB::table('users')->delete();

        User::create([
            'name'=>'Sergio Guillen Mantilla',
            'username'=>'donkeysharp',
            'email'=>'serguimant@gmail.com',
            'password'=>Hash::make('12345'),
            'country'=>'BO'
        ]);
        User::create([
            'name'=>'Fernando Guillen Mantilla',
            'username'=>'ferdo',
            'email'=>'fernando@gmail.com',
            'password'=>Hash::make('12345'),
            'country'=>'BO'
        ]);
    }
}
