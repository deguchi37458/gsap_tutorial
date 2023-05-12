<?php namespace Util\Command;

use Util\Infra\Command\Command;

/**
 * ドキュメントルートの設定を行う
 * Class Migrate
 * @package Util\Command
 */
class ChangeDocRoot extends Command
{
	/**
	 * @param array $config
	 * @return string
	 */
    protected function body($config = array())
    {
		$message = '';

        //DB名の環境変数が設定されている場合のみ
		if(getenv('DOCUMENT_ROOT')){
			$DOCUMENT_ROOT = getenv('DOCUMENT_ROOT');

			//see https://hub.docker.com/_/php/
			//複数実行した場合追記にならないように「.*」追加
			exec("sed -ri -e 's!/var/www/html.*!${DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf");
			exec("sed -ri -e 's!/var/www/.*>!${DOCUMENT_ROOT}>!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf");
		}

        return $message;
    }
}