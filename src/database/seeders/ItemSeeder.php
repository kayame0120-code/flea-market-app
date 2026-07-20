<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            ['name' => '腕時計', 'price' => 15000, 'brand' => 'Rolax', 'description' => 'スタイリッシュなデザインのメンズ腕時計', 'condition' => 1, 'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg', 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HDD', 'price' => 5000, 'brand' => '西芝', 'description' => '高速で信頼性の高いハードディスク', 'condition' => 2, 'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg', 'user_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '玉ねぎ3束', 'price' => 300, 'brand' => null, 'description' => '新鮮な玉ねぎ3束のセット', 'condition' => 3, 'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg', 'user_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '革靴', 'price' => 4000, 'brand' => null, 'description' => 'クラシックなデザインの革靴', 'condition' => 4, 'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg', 'user_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ノートPC', 'price' => 45000, 'brand' => null, 'description' => '高性能なノートパソコン', 'condition' => 1, 'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg', 'user_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'マイク', 'price' => 8000, 'brand' => null, 'description' => '高音質のレコーディング用マイク', 'condition' => 2, 'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg', 'user_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ショルダーバッグ', 'price' => 3500, 'brand' => null, 'description' => 'おしゃれなショルダーバッグ', 'condition' => 3, 'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg', 'user_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'タンブラー', 'price' => 500, 'brand' => null, 'description' => '使いやすいタンブラー', 'condition' => 4, 'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg', 'user_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'コーヒーミル', 'price' => 4000, 'brand' => 'Starbacks', 'description' => '手動のコーヒーミル', 'condition' => 1, 'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg', 'user_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'メイクセット', 'price' => 2500, 'brand' => null, 'description' => '便利なメイクアップセット', 'condition' => 2, 'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg', 'user_id' => 10, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
