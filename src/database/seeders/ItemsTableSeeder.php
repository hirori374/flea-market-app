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
            'image' => 'item-img/watch.jpg',
            'condition' => '良好',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'HDD',
            'brand' => '西芝',
            'price' => '5000',
            'image' => 'item-img/HDD.jpg',
            'condition' => '目立った傷や汚れなし',
            'description' => '高速で信頼性の高いハードディスク',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => '玉ねぎ3束',
            'price' => '300',
            'image' => 'item-img/onion.jpg',
            'condition' => 'やや傷や汚れあり',
            'description' => '新鮮な玉ねぎ3束のセット',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => '革靴',
            'price' => '4000',
            'image' => 'item-img/shoes.jpg',
            'condition' => '状態が悪い',
            'description' => 'クラシックなデザインの革靴',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'ノートPC',
            'price' => '45000',
            'image' => 'item-img/PC.jpg',
            'condition' => '良好',
            'description' => '高性能なノートパソコン',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'マイク',
            'price' => '8000',
            'image' => 'item-img/mic.jpg',
            'condition' => '目立った傷や汚れなし',
            'description' => '高音質のレコーディング用マイク',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'ショルダーバッグ',
            'price' => '3500',
            'image' => 'item-img/bag.jpg',
            'condition' => 'やや傷や汚れあり',
            'description' => 'おしゃれなショルダーバッグ',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'タンブラー',
            'price' => '500',
            'image' => 'item-img/tumbler.jpg',
            'condition' => '状態が悪い',
            'description' => '使いやすいタンブラー',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'コーヒーミル',
            'brand' => 'Starbacks',
            'price' => '4000',
            'image' => 'item-img/mill.jpg',
            'condition' => '良好',
            'description' => '手動のコーヒーミル',
        ];
        DB::table('items')->insert($param);
        $param = [
            'name' => 'メイクセット',
            'price' => '2500',
            'image' => 'item-img/cosmetics.jpg',
            'condition' => '目立った傷や汚れなし',
            'description' => '便利なメイクアップセット',
        ];
        DB::table('items')->insert($param);
    }
}
