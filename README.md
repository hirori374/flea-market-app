#アプリケーション名
coachtechフリマ

##環境構築
###Dockerビルド
1.git clone git@github.com:coachtech-material/laravel-docker-template.git
2.mv laravel-docker-template test_contact-form
3.docker-compose up -d --build

###Laravel環境構築
1.composer install
2.cp .env.example .env
3.php artisan key:generate

コントローラ 
1.php artisan make:controller ItemController 
2.php artisan make:controller UserController

マイグレーション 
1.php artisan make:migration create_categories_table 
2.php artisan make:migration create_items_table
3.php artisan make:migration create_item_category_table
4.php artisan make:migration create_purchases_table
5.php artisan make:migration create_item_user_favorites_table
6.php artisan make:migration create_comments_table
7.php artisan migrate

モデル 
1.php artisan make:model Category
2.php artisan make:model Item
3.php artisan make:model Purchase
4.php artisan make:model Comment

シーディング 
1.php artisan make:seeder CategoriesTableSeeder
2.php artisan make:seeder ItemsTableSeeder
3.php artisan db:seed

##使用技術 
・PHP 7.4.9 
・Laravel Framework 8.83.8 
・Mysql 8.0.26

##ER図
![Alt text](/src/ER.png)

##URL 
・開発環境：http://localhost/ 
・phpMyAdmin：http://localhost:8080/
