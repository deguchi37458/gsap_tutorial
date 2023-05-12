<?php namespace util\infra\http;

/**
 * Class Rooting
 * @package util\infra\http
 */
class Rooting
{
    const DEFAULT_ACTION = 'default';
    protected $box = array();

    protected $response = array();

    /**
     * Rooting constructor.
     * @param $response
     */
    public function __construct($response = array())
    {
        $this->response = $response;
    }

    public function e($v)
    {
        return $v;
    }

    /**
     * 処理の設定
     * @param $httpMethod
     * @param \Closure $fn
     * @param string $key
     */
    protected function setBox($httpMethod, $fn, $key){
        $this->box[$httpMethod][$key] = array(
            'callback'  => $fn,
        );
    }

	/**
	 * 処理の設定
	 * @param $httpMethod
	 * @param string $key
	 * @return array
	 */
    public function getBox($httpMethod, $key){
        return $this->box[$httpMethod][$key]['callback'];
    }

	/**
	 * メソッドの実行
	 * @param $httpMethod
	 * @param $key
	 * @param $param
	 * @return mixed
	 */
    public function excBox($httpMethod, $key, $param=[]){
        if(array_key_exists($httpMethod, $this->box)){
            $actions = $this->box[$httpMethod];
            if(array_key_exists($key, $actions)) {
                $target = $actions[$key];
                return call_user_func($target['callback'], new Query(Query::getRequestParamater()), $this->response, $param);
            }
        }

        self::notfound404();
//        throw new \Exception('Method not found.');
    }

    /**
     * GET送信の時に指定の処理を実行
     * @param \Closure $fn
     * @param string $key
     * @return $this
     */
    public function isGet($fn, $key = self::DEFAULT_ACTION)
    {
        $this->setBox('GET', $fn, $key);
        return $this;
    }

	/**
	 * POST送信の時に指定の処理を実行
	 * @param \Closure $fn
	 * @param string $key
	 * @return $this
	 */
	public function isPost($fn, $key = self::DEFAULT_ACTION)
	{
		$this->setBox('POST', $fn, $key);
		return $this;
	}

	/**
	 * 終了
	 * @param \Closure $fn
	 * @return array
	 */
    public function end($fn = null)
    {
        $action = isset($_GET['action']) ? $_GET['action'] : self::DEFAULT_ACTION;
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $result = $this->excBox($httpMethod, $action);
        if(is_callable($fn)){
			$result = call_user_func($fn, new Query(Query::getRequestParamater()), $result, $this->response);
		}
		return $result;
    }

	/**
	 * 301転送
	 * @param $path
	 */
	public static function redirect($path)
	{
		header( "HTTP/1.1 301 Moved Permanently" ) ;
		header( "Location: $path" ) ;
		exit;
	}

	/**
	 * 404転送
	 * @param string $path
	 */
	public static function notfound404($path = '/404.html')
	{
		header("HTTP/1.0 404 Not Found");
		$host = parse_url($path, PHP_URL_HOST);
		if(!empty($path)){
			if(empty($host)){
				$path = SITE_URL. $path;
			}
			$array = get_headers($path);
			if(strpos($array[0],'OK')){
				print(file_get_contents($path));
			}
		}
		exit;
	}
}

/**
 * ルーティングで解決するメソッドが存在しない場合のエラー
 * Class RootingMethodNotFoundException
 * @package util\infra\http
 */
class RootingMethodNotFoundException extends \Exception
{
    public function __construct($message = 'ルーティングで解決するメソッドが存在しませんでした。')
    {
        parent::__construct($message);
    }
}

