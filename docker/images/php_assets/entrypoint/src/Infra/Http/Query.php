<?php namespace util\infra\http;

/**
 * Class Query
 * @package util\infra\http
 */
class Query
{
    /**
     * @var array
     */
    protected $v = array();

    /**
     * Query constructor.
     * @param $v
     */
    public function __construct($v){ $this->v = $v; }

	/**
	 * @param $k
	 * @return string
	 */
	public function has($k)
	{
		if(array_key_exists($k, $this->v) && !empty($this->v[$k])){
			return true;
		}
		return false;
	}

	/**
	 * @param $k
	 * @param string $d
	 * @return string
	 */
	public function get($k , $d = '')
	{
        if(array_key_exists($k, $this->v)){
            return $this->v[$k];
        }

        return $d;
    }

    /**
     * @return array
     */
    public function all(){ return $this->v; }

    /**
     * リクエストメソッドをもとにリクエストパラメータを返す
     * @return array
     */
    public static function getRequestParamater(){
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                return $_GET;
            case 'POST':
                return $_POST;
            default:
                return array();
        }

    }

}