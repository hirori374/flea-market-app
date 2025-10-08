<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => '15000',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'condition' => '良好',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'HDD',
            'brand' => '西芝',
            'price' => '5000',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'condition' => '目立った傷や汚れなし',
            'description' => '高速で信頼性の高いハードディスク',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => '玉ねぎ3束',
            'price' => '300',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'condition' => 'やや傷や汚れあり',
            'description' => '新鮮な玉ねぎ3束のセット',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => '革靴',
            'price' => '4000',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'condition' => '状態が悪い',
            'description' => 'クラシックなデザインの革靴',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'ノートPC',
            'price' => '45000',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'condition' => '良好',
            'description' => '高性能なノートパソコン',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'マイク',
            'price' => '8000',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'condition' => '目立った傷や汚れなし',
            'description' => '高音質のレコーディング用マイク',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'ショルダーバッグ',
            'price' => '3500',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'condition' => 'やや傷や汚れあり',
            'description' => 'おしゃれなショルダーバッグ',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'タンブラー',
            'price' => '500',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'condition' => '状態が悪い',
            'description' => '使いやすいタンブラー',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'コーヒーミル',
            'brand' => 'Starbacks',
            'price' => '4000',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'condition' => '良好',
            'description' => '手動のコーヒーミル',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'メイクセット',
            'price' => '2500',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'condition' => '目立った傷や汚れなし',
            'description' => '便利なメイクアップセット',
        ];
        DB::table('items')->insert($param);
    }
}
