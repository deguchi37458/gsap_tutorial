<?php namespace Util\Context\Migration\Repository;

use Util\Infra\Db\Connection;
use Util\Infra\Db\DBSetting;

class MigrationRepository extends Connection
{
	protected $table = '_migrate_version';

	/**
	 * マイグレーション用テーブルの作成
	 */
	public function createMigrateTable(){
		self::$conn->exec("
			CREATE TABLE IF NOT EXISTS `{$this->table}` (
			`version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`created` datetime NOT NULL,
			PRIMARY KEY (`version`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");
	}

	/**
	 * 最後にインポートしたファイル名の取得
	 * @return string
	 */
	protected function lastSqlFile(){
		$queryBuilder = self::$conn->createQueryBuilder();
		$sql = $queryBuilder
			->select("*")
			->from($this->table, "migrate")
			->orderBy('version', 'DESC')
			->getSQL();
		$result = self::$conn->executeQuery($sql)->fetch();
		return $result ? $result['version'] : '';
	}
	/**
	 * SQLファイルパスのリストを取得
	 * @return array
	 */
	protected function sqlFiles(){
		$directory = RESOURCE_DIR. '/sql';
		$fileList = scandir($directory);

		$result = array();

		foreach($fileList as $file){
			$filePath = $directory. '/'. $file;
			// sqlファイルの場合のみ
			if(!is_dir(($filePath)) && pathinfo($filePath, PATHINFO_EXTENSION) == 'sql'){
				$result[$file] = $filePath;
			}
		}
		return $result;
   	}

	/**
	 * SQLファイルパスのリストを取得
	 * @return array
	 */
	protected function importSqlFiles(){
		$result = array();
		$fileList = $this->sqlFiles();
		$lastSqlFile = $this->lastSqlFile();

		//初回インポートの場合
		if(empty($lastSqlFile)){
			return $fileList;
		}

		//前回取り込んだもの以降を取得
		$isNew = false;
		foreach($fileList as $name => $path){
			if($isNew){
				$result[$name] = $path;
			}
			if($name == $lastSqlFile){
				$isNew = true;
			}
		}
		return $result;
	}

	/**
	 * SQLファイルパスのリストを取得
	 * @return array
	 */
	public function import(){
		$fileList = $this->importSqlFiles();
		foreach($fileList as $name => $path){
			echo "インポート: ${name} ...    ";
			passthru("mysql -u ". DBSetting::USER ." -p". DBSetting::PASSWORD. "  -h ". DBSetting::HOST. " ". getenv('DB_NAME'). " < ". $path, $error);
			if($error){
				echo 'エラー!!'. PHP_EOL;
				echo '終了します!!'. PHP_EOL;
				exit;
			}else{
				echo '完了!!'. PHP_EOL;
				$this->insertMigrateResult($name);
			}
		}
		return $fileList;
	}

	/**
	 * インポートしたSQLファイルの登録
	 * @param $file
	 */
	protected function insertMigrateResult($file){
		$today = new \DateTime();
		$queryBuilder = self::$conn->createQueryBuilder();
		$sql = $queryBuilder
			->insert($this->table)
			->setValue('version', ":version")
			->setParameter('version', $file)
			->setValue('created', ":created")
			->setParameter('created', $today->format('Y-m-d H:i:s'));

		$sql->execute();
		//SQL内にトランザクションの記載があった場合に備えて明示的コミット
		//(SET AUTOCOMMIT = 0; START TRANSACTION;) 対策
		self::$conn->exec("COMMIT;");
	}
}
