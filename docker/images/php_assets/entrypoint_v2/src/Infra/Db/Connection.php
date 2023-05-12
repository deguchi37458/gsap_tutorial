<?php namespace Util\Infra\Db;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\EchoSQLLogger;

/**
 * Class Connection
 * @package Util\Infra\Db
 */
class Connection
{
    /**
     * @var  \Doctrine\DBAL\Connection
     */
    protected static $conn = null;

    /**
     * CMSDBRepository constructor.
     */
    public function __construct()
    {
        self::$conn = self::getConnection();
    }

    /**
     * DBのコネクションを取得
     * @return \Doctrine\DBAL\Connection|null
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function getConnection()
    {
        if( !empty(self::$conn) ){
            return self::$conn;
        }

		$config = new Configuration();
		$connectionParams = array(
			"dbname"    => getenv('DB_NAME'),
			"user"      => DBSetting::USER,
			"password"  => DBSetting::PASSWORD,
			"host"      => DBSetting::HOST,
			"driver"    => DBSetting::DRIVER,
//            "charset"   => DBSetting::CHARSET,
//            'driverOptions' => array(
//				1002 => 'SET NAMES ' . DBSetting::CHARSET
//			)
		);

        if(DBSetting::DEBUG_MODE){
            $config->setSQLLogger( new EchoSQLLogger() );
        }

		self::$conn = DriverManager::getConnection( $connectionParams, $config );

        return self::$conn;
    }

    /**
     * @return \Doctrine\DBAL\Query\QueryBuilder
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function createQueryBuilder()
    {
        return self::getConnection()->createQueryBuilder();
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function clean()
    {
        $ret = self::getConnection()->fetchArray("show tables");
        $ret = empty($ret)? array(): $ret;

        foreach( $ret as $name ){
            self::getConnection()->exec("DROP TABLE " . $name);
        }

        passthru("mysql -u " . DB_USER ." -p" . DB_PASSWORD . " " . DB_NAME . " < " . DB_SQL_FILE);
    }

    /**
     * テーブル一覧の表示
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    protected static function tables()
    {
        $ret = self::getConnection()->fetchArray("show tables");
        if( empty( $ret ) ) return $ret;

        foreach( $ret as $name ){
            var_dump($name);
        }
    }

}