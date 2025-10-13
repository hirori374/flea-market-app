#アプリケーション名
coachtechフリマ

##環境構築
###Dockerビルド
・git clone git@github.com:hirori374/flea-market-app.git
・docker-compose.ymlのservicesに以下を追記
  services:
    mailhog:
      image: mailhog/mailhog
      ports:
        - "8025:8025"
        - "1025:1025"
・docker-compose up -d --build

###Laravel環境構築
・docker-compose exec php bash
・composer install
・cp .env.example .env、データベース情報の変更
・.envファイルにMailHog設定の追記
  MAIL_MAILER=smtp
  MAIL_HOST=mailhog
  MAIL_PORT=1025
  MAIL_USERNAME=null
  MAIL_PASSWORD=null
  MAIL_ENCRYPTION=null
・php artisan key:generate
・docker-compose exec php vendor/bin/phpunit
・php artisan migrate
・php artisan db:seed
・php artisan storage:link

###Stripe設定
・Stripe公式サイトにアクセスし、テスト用APIキーを取得
・.envファイルに以下を追加
STRIPE_KEY=pk_test_xxxxxxxxxxxxxxxxxxxxx
STRIPE_SECRET=sk_test_xxxxxxxxxxxxxxxxxxxxx
・php artisan config:cache

##使用技術 
・PHP 7.4.9 
・Laravel Framework 8.83.8 
・Mysql 8.0.26
・Stripe Checkout API

##ER図
![Alt text](/src/ER.png)

##URL 
・商品一覧：http://localhost/
・ユーザー登録：http://localhost/register
・phpMyAdmin：http://localhost:8080/
・mailhog：http://localhost:8025/
