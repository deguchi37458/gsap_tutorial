<?php namespace util\infra\session;

/**
 * Class Session
 * @package JP\Grampus\Session
 */
class Session
{

    /**
     * @var string セッションID
     */
    protected static $id = '';

    /**
     * @var string セッション名
     */
    protected static $name = '';

    /**
     * トークンキー
     * @var string
     */
    protected static $TOKEN = '_token';

    /**
     * セッション設定項目
     */
    protected static $config = array(
        'lifetime'                  => '10000',
        'session.use_only_cookies'  => '1',
        // md5よりさらに予測困難なsha1でセッションIDを生成
        'session.hash_function'     => '1',
        // セッションIDをURLパラメータに書かない
        'session.use_trans_sid'     => '0',
        // HTTP <-> HTTPS 間でセッションの受渡しやCSRF対策でフォームに
        // 自動付与されるoutput_add_rewrite_varでURLパラメータに書かれ
        // ないようにする
        'url_rewriter.tags'         => 'form='
    );

    /**
     *
     */
    const STRICT_SESSION_ENCRYPT_NAME = 'strict_session_serialized';

    /**
     * 特になし
     */
    protected function __construct(){}


    /**
     * セッションの設定項目の登録を行います。
     * 値が空のものは無視されます。
     * @param $config
     */
    public static function configure($config){
        foreach($config as $key => $value){
            if(!empty($value)){
                static::$config[$key] = $value;
            }
        }
    }

    /**
     * セッションIDの設定。
     * 値の指定がなければセッションIDを自働生成
     * @param string $id
     */
    public static function setId($id = '')
    {
        if(empty($id)) {
            static::$id = static::generateSessionId();
        }else{
            static::$id = $id;
        }
    }

    /**
     * セッションIDの取得
     */
    public static function getId()
    {
        return static::$id;
    }

    /**
     * セッションを開始する
     */
    public static function start()
    {
        if ( !static::isStarted() ) {

            //設定項目を元にセッション値の設定
            foreach(self::$config as $key => $value){
                ini_set( $key, $value );
            }

            //セキュア設定
            if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] = 'on') {
                ini_set('session.cookie_secure', 1);
                session_name('SECURE_'.session_name());
            }

            session_start();
        }
    }

    /**
     * セッションの破棄
     */
    public static function destroy()
    {
        $_SESSION = array();
        // セッションを切断するにはセッションクッキーも削除する。
        // Note: セッション情報だけでなくセッションを破壊する。
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }

        // HTTP <-> HTTPS 間でセッションの受渡し用Cookieも削除
        if (isset($_COOKIE[self::STRICT_SESSION_ENCRYPT_NAME])) {
            setcookie(self::STRICT_SESSION_ENCRYPT_NAME, '', time()-42000, '/');
        }

        session_destroy();
    }

    /**
     * セッション変数に値を追加する
     * @param $key string セッションキー
     * @param $value  mixed セッション値
     */
    public static function set($key, $value)
    {
        static::start();
        $_SESSION[$key] = $value;
    }

    /**
     * セッションから値を取得する
     * @param $key セッションキー
     * @param string $default セッション値が存在しない場合のデフォルト値
     * @return mixed セッション値
     */
    public static function get($key, $default = '')
    {
        static::start();
        if (static::has($key)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * 指定のキーで値が存在するか確認する
     * @param $key 検索するキー
     * @return bool 指定のキーが存在するか
     */
    public static function has($key)
    {
        static::start();
        if (array_key_exists($key, $_SESSION)) {
            return true;
        }
        return false;
    }

    /**
     * 指定のキーの値を削除する
     * キー自体は保つ。
     * @param $key 削除する値のキー
     */
    public static function clear($key)
    {
        static::start();
        if (static::has($key)) {
            $_SESSION[$key] = '';
        }
    }

    /**
     * キーごと削除
     * @param $key
     */
    public static function delete($key)
    {
        static::start();
        unset($_SESSION[$key]);
    }

    /**
     * すべての値を返す
     * @param array 全てのセッション情報
     */
    public static function all()
    {
        static::start();
        return $_SESSION;
    }

    /**
     * セッションが開始されているか確認する。
     * @return bool セッションが開始されているか
     */
    public static function isStarted()
    {
        return isset($_SESSION);
    }


    /**
     * @param bool|false $isGenerate
     * @return mixed
     */
    public static function token($isGenerate = false)
    {
        if($isGenerate == true || !self::has(self::$TOKEN)){
            self::set(self::$TOKEN, rtrim(base64_encode(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)),'=') );
        }

        return self::getToken();

    }

    /**
     * @return mixed
     */
    public static function getToken()
    {
        return self::get(self::$TOKEN);
    }

    /**
     * セッションIDの取得
     * @return mixed セッションID
     */
    protected static function generateSessionId()
    {
        return sha1(uniqid(true).str_random(25).microtime(true));
    }
}