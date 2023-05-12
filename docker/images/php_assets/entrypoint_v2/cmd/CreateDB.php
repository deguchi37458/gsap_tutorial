<?php namespace Util\Command;

use Util\Infra\Command\Command;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\EchoSQLLogger;
use Util\Infra\Db\DBSetting;


/**
 * DBの作成を行う
 * Class CreateDB
 * @package Util\Command
 */
class CreateDB extends Command
{
	/**
	 * @param array $config
	 * @return string
	 */
    protected function body($config = array())
    {
		$message = '';

        //DB名の環境変数が設定されている場合のみ
		if(getenv('DB_NAME')){
			$this->createDatabase();
			$message = 'DBの作成が完了しました'. PHP_EOL;
		}

		return $message;
    }

	/**
	 * データベースの作成(ユーザの作成・権限付与を含む)
	 */
    protected function createDatabase(){
		$con = $this->getConnection();
		$DB_NAME = getenv('DB_NAME');
		$DB_USER = getenv('DB_USER');
		$DB_PW = getenv('DB_PW');

		$con->exec("SET @@session.sql_mode = '';");
		$con->exec("CREATE DATABASE IF NOT EXISTS `${DB_NAME}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;");
		$con->exec("CREATE USER IF NOT EXISTS `${DB_USER}`@'%' IDENTIFIED BY '${DB_PW}';");
		$con->exec("GRANT ALL PRIVILEGES ON `${DB_NAME}`.* TO `${DB_USER}`@'%';");
		$con->exec("FLUSH PRIVILEGES");

	}

	private function getConnection(){
		$config = new Configuration();
		$connectionParams = array(
			'dbname'    => '',
			'user'      => DBSetting::USER,
			'password'  => DBSetting::PASSWORD,
			'host'      => DBSetting::HOST,
			'driver'    => 'pdo_mysql',
		);

        if(DBSetting::DEBUG_MODE){
            $config->setSQLLogger( new EchoSQLLogger() );
        }

		return DriverManager::getConnection( $connectionParams, $config );
	}
}
