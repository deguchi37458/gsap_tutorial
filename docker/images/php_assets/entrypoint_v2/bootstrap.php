<?php require_once(__DIR__ . '/vendor/autoload.php');

use Util\Infra\Command\CommandList;
use Util\Command\CreateDB;
use Util\Command\Migrate;
use Util\Command\ChangeDocRoot;
use Util\Command\SettingSMTP;
use Util\Command\Composer;
use Util\Command\SettingBasicAuth;

define('ENTORYPOINT_ROOT', __DIR__);
define('RESOURCE_DIR', ENTORYPOINT_ROOT. '/resource');


//コマンド処理を登録し実行
CommandList::add(new CreateDB());
CommandList::add(new Migrate());
CommandList::add(new ChangeDocRoot());
CommandList::add(new SettingSMTP());
CommandList::add(new Composer());
CommandList::add(new SettingBasicAuth());
CommandList::executes();
