<?php

class TemplateSeeder extends Seeder {
    public function run() {
        DB::table('templates')->delete();
        $templates = [
            ["name" => "template 1", "description" => "bro, the first!!", "user_id" => 1],
            ["name" => "template 2", "description" => "bro, the second!", "user_id" => 1],
            ["name" => "template 3", "description" => "bro, the thrid!!", "user_id" => 1],
        ];
        DB::table('templates')->insert($templates);

        DB::table('commands')->delete();
        $commands = [
            ['name'=>'turn lights on', 'short_cmd'=>'tl_on',
             'cmd_type'=>'string', 'template_id'=>1
            ]
        ];
        DB::table('commands')->insert($commands);
    }
}
