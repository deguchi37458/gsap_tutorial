<?php namespace Util\Command;

use Util\Context\Migration\Repository\MigrationRepository;
use Util\Infra\Command\Command;

/**
 * DBの定義更新・データのインポートを行う
 * Class Migrate
 * @package Util\Command
 */
class Migrate extends Command
{
	/**
	 * @param array $config
	 * @return string
	 */
    protected function body($config = array())
    {
		$message = 'マイグレーションスキップ(SQLファイルなし)';
        $repository = new MigrationRepository();

        //DB名の環境変数が設定されている場合のみ
		if(getenv('DB_NAME')){
			$repository->createMigrateTable();
			$fileList = $repository->import();
			$message = count($fileList). '件のファイルのインポートが完了しました'. PHP_EOL;
		}

		return $message;
    }
}