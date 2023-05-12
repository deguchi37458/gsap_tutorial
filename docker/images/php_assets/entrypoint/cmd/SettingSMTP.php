<?php namespace Util\Command;

use Util\Infra\Command\Command;

/**
 * SMTPアカウントの設定
 * Class SettingSMTP
 * @package Util\Command
 */
class SettingSMTP extends Command
{
	/**
	 * @param array $config
	 * @return string
	 */
    protected function body($config = array())
    {
		$message = '';

        //SMTPユーザの環境変数が設定されている場合のみ
		if(getenv('SMTP_USER')){
			$this->writeConfigFile();
			$message = 'メール設定完了';
		}

        return $message;
    }

	/**
	 * 設定内容
	 * @return string
	 */
	protected function configData(){
		$file = file_get_contents(RESOURCE_DIR. '/setting/mail/.msmtprc');
		return str_replace(array(
			'{{host}}', '{{port}}', '{{user}}', '{{pw}}'
		), array(
			getenv('SMTP_HOST'), getenv('SMTP_PORT'), getenv('SMTP_USER'), getenv('SMTP_PW')
		), $file);
	}

	/**
	 * 設定内容
	 * @return string
	 */
	protected function writeConfigFile(){
		$fileName = '/etc/msmtp/.msmtprc';
		file_put_contents($fileName, $this->configData());
		chmod($fileName, 0600);
		chown($fileName, 'www-data');
		chgrp($fileName, 'www-data');
	}
}
