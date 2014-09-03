<?php
class CommunicationTypeSeeder extends Seeder {
    public function run() {
        CommunicationType::create([
            'code'=>'bluetooth',
            'name'=>'Bluetooth Communication'
        ]);
    }
}
