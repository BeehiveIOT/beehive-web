<?php

class DeviceSeeder extends Seeder {
    public function run() {
        DB::table('devices')->delete();
        $devices = [];
        for($i = 1; $i <= 10; $i++) {
            $devices[] = [
                'id'=>$i,
                'uuid'=>GUID::generate(),
                'device_secret'=>GUID::generate(),
                'name'=>"Device $i",
                'description'=>"device yeah number $i",
                'is_public'=>true,
            ];
        }
        DB::table('devices')->insert($devices);

        $user1 = User::where('username', '=', 'donkeysharp')->get()->first();
        $user2 = User::where('username', '=', 'ferdo')->get()->first();
        DB::table('device_admin')->delete();
        $relation = [];
        for($i = 1; $i <= 10; $i++) {
            if ($i % 2 == 0) {
                $userId = $user1->id;
            }
            else {
                $userId = $user2->id;
            }

            $relation[] = [
                'id'=>$i,
                'user_id'=>$userId,
                'device_id' => $i
            ];
        }
        DB::table('device_admin')->insert($relation);
    }
}
