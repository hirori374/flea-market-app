#アプリケーション名
coachtechフリマ

##環境構築
###Dockerビルド
1. git clone git@github.com:hirori374/flea-market-app.git
2. docker-compose.ymlのservicesに以下を追記
  services:
    mailhog:
      image: mailhog/mailhog
      ports:
        - "8025:8025"
        - "1025:1025"
3. docker-compose up -d --build

###Laravel環境構築
1. docker-compose exec php bash
2. composer install
3. cp .env.example .env、データベース情報の変更
4. .envファイルにMailHog設定の追記
  MAIL_MAILER=smtp
  MAIL_HOST=mailhog
  MAIL_PORT=1025
  MAIL_USERNAME=null
  MAIL_PASSWORD=null
  MAIL_ENCRYPTION=null
5. php artisan key:generate
6. docker-compose exec php vendor/bin/phpunit
7. php artisan migrate
8. php artisan db:seed
9. php artisan storage:link

###Stripe設定
1. Stripe公式サイトにアクセスし、テスト用APIキーを取得
2. .envファイルに以下を追加
STRIPE_KEY=pk_test_xxxxxxxxxxxxxxxxxxxxx
STRIPE_SECRET=sk_test_xxxxxxxxxxxxxxxxxxxxx
3. php artisan config:cache

##テスト環境設定
1. docker-compose exec php cp .env .env.testing
2. docker-compose exec php php artisan key:generate --env=testing
3. docker-compose exec php php artisan migrate --env=testing
4. docker-compose exec php vendor/bin/phpunit

##使用技術 
・PHP 8.2.29
・Laravel Framework 8.83.29
・Mysql 8.0.26
・PHPUnit 9.6.29
・Stripe Checkout API

##ER図
![Alt text](/src/ER.png)

##URL 
・商品一覧：http://localhost/
・ユーザー登録：http://localhost/register
・phpMyAdmin：http://localhost:8080/
・mailhog：http://localhost:8025/
