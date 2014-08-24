<?php
class UserSeeder extends Seeder {
    public function run() {
        User::create([
            'name'=>'Sergio Guillen Mantilla',
            'username'=>'donkeysharp',
            'email'=>'serguimant@gmail.com',
            'password'=>Hash::make('12345'),
            'country'=>'BO'
        ]);
    }
}
