<?php namespace Util\Infra\Command;

/**
 * コマンド処理失敗例外
 * Class CommandFailException
 * @package Util\Infra\Command
 */
class CommandFailException extends \Exception
{
    public function __construct($message, $code, \Exception $previous)
    {
        parent::__construct($message, $code, $previous);
    }
}