<?php

class TemplateSeeder extends Seeder {
    public function run() {
        DB::table('templates')->delete();
        $templates = [
            ["name" => "template 1", "description" => "bro, the first!!", "user_id" => 1],
            ["name" => "template 2", "description" => "bro, the second!", "user_id" => 1],
            ["name" => "template 3", "description" => "bro, the thrid!!", "user_id" => 1],
            ["name" => "Cerebro de auto", "description" => "Template para controlar dispositivos de auto", "user_id" => 1],
        ];
        DB::table('templates')->insert($templates);

        DB::table('commands')->delete();
        $commands = [
            ['name'=>'turn lights on', 'short_cmd'=>'tl_on',
             'cmd_type'=>'string', 'template_id'=>1
            ],
            [
                'name' => 'Activar GPS', 'short_cmd' => 'G',
                'cmd_type' => 'string', 'template_id'=>4
            ],
            [
                'name' => 'Desactivar GPS', 'short_cmd' => 'H',
                'cmd_type' => 'string', 'template_id'=>4
            ],
            [
                'name' => 'Frenar', 'short_cmd' => 'W',
                'cmd_type' => 'string', 'template_id'=>4
            ],
        ];
        DB::table('commands')->insert($commands);
    }
}
