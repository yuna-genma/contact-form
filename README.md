# contact-form

## 概要

旧教材のLaravel演習講座の『お問い合わせフォーム』を、新教材のLaravel Sailの環境で作成しました。

## 作成の流れ

### 1. 要件定義

＊基本情報

- アプリ名：お問い合わせフォーム
- 利用者：個人ユーザー（ログインはあってもなくても）
- 目的：ユーザーがお問い合わせ内容を送信する

＊フォームの内容について

- 名前：必須
- メールアドレス：必須
- 電話番号：必須
- お問い合わせ内容：空欄可（長文OK）

### 2. 整理

＊フォームのCRUD

- 名前・メールアドレス・電話番号の入力フォームの表示 '/' ContactController＠index　GET
- 入力内容確認画面 '/' ContactController@store　POST
- 完了ページの表示 '/contacts' ContactController@thanks　POST

### 3. バリデーション・テスト要件書き出し

＊バリデーション

- name required, string, max:255
- email required, email, max:255
- tell required, string, min:10, max:11
- content nullable,string

＊テスト要件

1. 入力フォームを表示できる
2. お問い合わせを作成できる　確認画面の表示
3. 完了画面を表示できる
4. 名前はが空だとバリデーションエラーになる
5. メールアドレスが空だとバリデーションエラーになる
6. 電話番号が空だとバリデーションエラーになる
7. 名前は255文字まで入力できる
8. 名前が256文字以上だとバリデーションエラーになる
9. メールアドレスは255文字まで入力できる
10. メールアドレスが256文字以上だとバリデーションエラーになる
11. 電話番号は10文字以上で入力できる
12. 電話番号は11文字以内で入力できる
13. 電話番号が9文字以下だとバリデーションエラーになる
14. 電話番号が12文字以上だとバリデーションエラーになる

### 4. 環境構築

#### 1. Laravelプロジェクトの作成

Dockerが起動していることを確認

```bash
# ホームディレクトリに移動
cd ~

# Laravelプロジェクトを作成
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    composer create-project laravel/laravel:^10.0 contact-form
```

#### 2. Laravel Sailのインストール

```bash
# プロジェクトディレクトリに移動
cd contact-form

# Laravel Sailをインストール
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    composer require laravel/sail --dev

# Sailの設定ファイルをパブリッシュ（MySQLを選択）
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    php artisan sail:install --with=mysql
```

#### 3. phpMyAdminの追加

`compose.yaml`を開き、`mysql`サービスの後に以下の設定を追加して保存する

```php
    phpmyadmin:
        image: 'phpmyadmin:latest'
        ports:
            - '${FORWARD_PHPMYADMIN_PORT:-8080}:80'
        environment:
            PMA_HOST: mysql
            PMA_USER: '${DB_USERNAME}'
            PMA_PASSWORD: '${DB_PASSWORD}'
        networks:
            - sail
        depends_on:
            - mysql
```

#### 4. フロントエンドのセットアップ

#### 5. Sailの起動とエイリアス設定

#### 6. 動作確認

### 5. 提供アセットの配置

### 6. Git/GitHub準備とIssue登録

### 7. マイグレーションの作成

### 8. モデル作成

### 9. CRUD機能の実装

### 10. テスト
