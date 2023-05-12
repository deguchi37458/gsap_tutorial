<?php namespace Util\Infra\Command;

/**
 * Class CommandList
 * @package Util\Infra\Command
 */
class CommandList
{
    protected static $list = array();

    /**
     * コマンドを追加する
     * @param Command $c
     */
    public static function add(Command $c){ array_push(self::$list, $c); }

    /**
     * 先頭のコマンドを実行し内容をキューから削除する。
     * @return bool true | false
     */
    public static function execute(){ return array_shift(self::$list)->execute(); }

    /**
     * 先頭からコマンドを全て随時実行し内容をキューから削除する。
     */
    public static function executes()
    {
        while( ( $target = array_shift( self::$list ) ) !== NULL ){
            $target->execute();
        }
    }
}