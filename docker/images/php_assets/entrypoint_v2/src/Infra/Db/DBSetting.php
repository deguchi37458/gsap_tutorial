<?php namespace Util\Infra\Db;

/**
 * DB設定
 * Class DBSetting
 * @package Util\Infra\Db
 */
class DBSetting
{
    const DRIVER     = "pdo_mysql";
	const HOST       = 'db';
	const USER       = 'root';
	const PASSWORD   = 'JJCV3703';
	//環境変数より指定
	const NAME       = '';
	const CHARSET    = 'UTF8';
    const DEBUG_MODE = false;
}