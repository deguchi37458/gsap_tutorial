<?php namespace Util\Infra\Db;

/**
 * Class DBAL
 * @package Util\Infra\Db
 */
class DBAL
{

    /**
     * @var string テーブル名
     */
    protected $table = "";

    protected $conn = null;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

    /**
     * テーブル名の取得
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * テーブルを綺麗にする。
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function truncate()
    {
        $sql = self::createQueryBuilder()->delete($this->table);

        return self::$conn->executeUpdate( $sql );
    }

}
