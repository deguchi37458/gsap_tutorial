# 開発環境構築手順

## Docker 本体のインストール(初回のみ)

自分の OS に合わせて下記手順にてインストールを行う。

### macOS

→ [Docker for Mac](https://store.docker.com/editions/community/docker-ce-desktop-mac)

### Windows 10

→ [Docker for Windows](https://store.docker.com/editions/community/docker-ce-desktop-windows)

## Docker イメージのビルド(初回のみ)

ターミナルにて、 `docker/images` に移動し下記コマンドを実行(結構時間かかる)

###### php5.3 の場合

```
docker build -t vogaro:php5.3 -f php5.3-apache/Dockerfile .
```

###### php5.6 の場合

```
docker build -t vogaro:php5.6 -f php5.6-apache/Dockerfile .
```

###### php7.0 の場合

```
docker build -t vogaro:php7.0 -f php7.0-apache/Dockerfile .
```

###### php7.1 の場合

```
docker build -t vogaro:php7.1 -f php7.1-apache/Dockerfile .
```

###### php7.2 の場合

```
docker build -t vogaro:php7.2 -f php7.2-apache/Dockerfile .
```

###### php7.3 の場合

```
docker build -t vogaro:php7.3 -f php7.3-apache/Dockerfile .
```

###### php7.4 の場合

```
docker build -t vogaro:php7.4 -f php7.4-apache/Dockerfile .
```

###### php8.0 の場合

```
docker build -t vogaro:php8.0 -f php8.0-apache/Dockerfile .
```

## Docker ネットワークの作成(初回のみ)

ターミナルにて、下記コマンドを実行(どのディレクトリでも OK)

```
docker network rm db-manage
docker network rm mysql5.6
docker network rm mysql5.7
docker network rm mysql8.0
docker network rm front
docker network create --driver bridge front
docker network create --driver bridge db-manage
docker network create --driver bridge mysql5.6
docker network create --driver bridge mysql5.7
docker network create --driver bridge mysql8.0
```

## 周辺環境構築(初回のみ)

ターミナルにて、docker/container/infra/default に移動して下記コマンドを実行

```
docker-compose up -d
```

-d オプションはバックグラウンド実行モード

## 使い方

### 設定ファイルの作成(案件導入時のみ)

#### ▼ システム動作環境は不要の場合

① ルートディレクトリの `docker-compose.yml` を案件のルートディレクトリにコピー  
② `docker-compose.yml` ファイル内のサブドメイン箇所を適宜書き換えて保存

#### ▼ システム動作環境は必要の場合

※システムメンバーが本番環境に合わせて作成すること！  
※フロントエンドはシステム箇所の有無を確認し、システムメンバーに依頼してください

【システムメンバー作業】  
① `docker/project/docker-compose.yml` を案件のルートディレクトリにコピー  
② ルートディレクトリに `.env.example` ファイルを作成  
③ 環境構築用のファイルは `/docker/sql` など `/docker` ディレクトリを作成し、そこで完結すること  
(マイグレーションファイル、アップロードファイルなど)

【作業者全員作業】  
④ `.env.example` をコピーし `.env` ファイルを作成  
⑤ `.env` ファイルにメールアドレスやパスワードなど機密情報を適宜書き換え

### 起動・停止(案件作業時毎回)

ターミナルにて、該当案件の `docker-compose.yml` ファイルがある階層に移動し下記コマンドを実行

##### 起動コマンド

```
docker-compose up -d
```

##### 停止コマンド

```
docker-compose down
```
