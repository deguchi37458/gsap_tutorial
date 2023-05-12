<?php namespace Util\Infra\Mail;

/**
 * メール設定
 * Class MailSetting
 * @package Util\Infra\Mail
 */
class MailSetting
{
    const TRANSFER_TO       = [ 'koyama@vogaro.co.jp' => '管理者' ];
    const TRANSFER_FROM     = [ 'bot@vogaro.co.jp' => 'タスクボット' ];
    const TRANSFER_SUBJECT  = "【通知】終了しました";
}