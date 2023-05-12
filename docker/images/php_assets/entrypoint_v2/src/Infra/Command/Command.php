<?php namespace Util\Infra\Command;

/**
 * Class Command
 * @package Util\Infra\Command
 */
abstract class Command
{
	/**
	 * ログファイルのパス
	 */
	const LOG_PATH = '';
    /**
     * @var bool ログを書き込むかのフラグ
     */
    public static $IS_LOG = false;

    /**
     * @var string 開始メッセージ(あれば)
     */
    protected $startMessage = '';

    /**
     * @var string 終了メッセージ(あれば)
     */
    protected $endMessage = '';

    /**
     * 特になし
     * Command constructor.
     */
    public function __construct(){}

    /**
     * 設定系
     */
    protected function config(){ return array(); }

    /**
     * 処理の組み立て
     * @param array $config
     * @return mixed
     */
    abstract protected function body($config = array());

    /**
     * コマンドの実行
     */
    public function execute()
    {
        $config = $this->config();
        $config = empty($config)? array(): $config;

		//処理の計測開始
		$start_time = microtime(true);
        $message = $this->body($config);
		//処理の計測終了
		$end_time = microtime(true);

        $this->writeLog(compact('start_time', 'end_time', 'message'));
    }

    /**
     * ログファイル名を取得します。
     * ファイル名の形式はapi_log_Y-m-d.txtになります。
     * @return string
     */
    public function fileName(){ return 'log_'. date('Y-m-d') . '.log'; }

    /**
     * ログの書き込み
     * @param $log
     */
    protected function writeLog($log)
    {
		if(!self::$IS_LOG || !isset($log['message'])){
			return;
		}

        $convert = function($time){
            $_time = $time;
            if($_time) {
                list($sec, $usec) = explode('.', $_time);
                return date('H:i:s', $sec);
            }

            return 0;
        };

        $start_time = $convert($log['start_time']);
        $end_time   = $convert($log['end_time']);

        $str = json_encode( array(
            'start_time'        => $start_time,
            'end_time'          => $end_time,
            'created'           => date('Y-m-d H:i:s') . ' ' . microtime(true),
            'message'           => $this->startMessage . ' ' . $log['message'] . ' ' . $this->endMessage
        ), JSON_UNESCAPED_UNICODE );

		file_put_contents(self::LOG_PATH . '/' . $this->fileName(), $str . PHP_EOL, FILE_APPEND);
    }
}