<?php
class UserSeeder extends Seeder {
    public function run() {
        DB::table('users')->delete();

        User::create([
            'name'=>'Dexter Douglas',
            'username'=>'user1',
            'email'=>'user1@foobar.com',
            'password'=>Hash::make('12345'),
            'country'=>'BO'
        ]);
        User::create([
            'name'=>'Chui Savedra',
            'username'=>'user2',
            'email'=>'user2@gmail.com',
            'password'=>Hash::make('12345'),
            'country'=>'BO'
        ]);
        User::create([
            'name'=>'Pedro Perez Pereira',
            'username'=>'user3',
            'email'=>'user3@foobar.com',
            'password'=>Hash::make('12345'),
            'country'=>'BO'
        ]);
        User::create([
            'name'=>'Juan Salvador Gaviota',
            'username'=>'user4',
            'email'=>'user4@foobar.com',
            'password'=>Hash::make('12345'),
            'country'=>'BO'
        ]);
    }
}
