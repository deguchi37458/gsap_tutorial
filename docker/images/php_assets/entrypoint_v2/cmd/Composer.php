<?php namespace Util\Command;

use Util\Infra\Command\Command;

/**
 * composer install
 * Class Composer
 * @package Util\Command
 */
class Composer extends Command
{
    /**
     * @param array $config
     * @return string
     */
    protected function body($config = array())
    {
        $message = '';

        // コンポーザーの環境変数が設定されている場合のみ
        if($COMPOSER_PATH = getenv('COMPOSER_PATH')){
            echo  'composerパッケージのインストール'. PHP_EOL;
            $docRoot = getenv('DOCUMENT_ROOT') ?: '/var/www/html';
            $command = "cd {$docRoot}/{$COMPOSER_PATH} && composer install";
            $command .= getenv('APP_ENV') != 'local' ? ' -n --prefer-dist --no-dev' : '';
            exec($command);

            $message = 'composerパッケージのインストールをしました。';
            echo  $message. PHP_EOL;
        }
        return $message;
    }
}
