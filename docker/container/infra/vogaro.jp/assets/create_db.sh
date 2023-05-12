#!/bin/sh
# このスクリプト(db_init.sh)のディレクトリの絶対パスを取得
DIR=$(cd $(dirname $0); pwd)
# MySQLをバッチモードで実行するコマンド
CMD_MYSQL="mysql --defaults-extra-file=$DIR/my.conf -h $DB_HOST"
$CMD_MYSQL -e "CREATE DATABASE IF NOT EXISTS $DB_NAME DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;"
$CMD_MYSQL -e "GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'%';"
$CMD_MYSQL -e "GRANT RELOAD ON *.* TO '$DB_USER'@'%' IDENTIFIED BY '$DB_PW';"