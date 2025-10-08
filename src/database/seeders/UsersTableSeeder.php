<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'マスカット',
            'email' => 'muscat@example.com',
            'password' => bcrypt('muscat3333'),
            'icon' => 'fruits-img/muscat.png'
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'キウイ',
            'email' => 'kiwi@example.com',
            'password' => bcrypt('kiwi5555'),
            'icon' => 'fruits-img/kiwi.png',
            'post_code' => '000-5555',
            'address' => '東京都',
            'building' => 'キウイ館303'
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'いちご',
            'email' => 'strawberry@example.com',
            'password' => bcrypt('strawberry00'),
            'icon' => 'fruits-img/strawberry.png',
            'post_code' => '000-0000',
            'address' => '神奈川県',
            'building' => '横浜シティハイツいちご東'
        ];
        DB::table('users')->insert($param);
    }
}
