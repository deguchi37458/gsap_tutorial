<?php namespace Util\Command;

use Util\Infra\Command\Command;

/**
 * ベーシック認証の設定
 * Class SettingBasicAuth
 * @package Util\Command
 */
class SettingBasicAuth extends Command
{
	/**
	 * @param array $config
	 * @return string
	 */
    protected function body($config = array())
    {
		$message = '';

        //ベーシック認証の環境変数が設定されている場合のみ
		if(getenv('AUTH_ID')){
			$VIRTUAL_HOST = getenv('VIRTUAL_HOST');
			$AUTH_ID = getenv('AUTH_ID');
			$AUTH_PW = getenv('AUTH_PW');
			exec("htpasswd -c -b /var/htpasswd/${VIRTUAL_HOST} ${AUTH_ID} ${AUTH_PW}");

			$message = 'ベーシック認証の設定をしました。';
		}

        return $message;
    }
}