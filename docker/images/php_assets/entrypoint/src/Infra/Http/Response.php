<?php namespace util\infra\http;

/**
 * Class Response
 * @package util\infra\http
 */
class Response
{
//	/**
//	 * @param \Closure fn
//	 */
//	public function echoJson($fn)
//	{
//		if(is_callable($fn)){
//			$response_data = call_user_func($fn, new Query(Query::getRequestParamater()));
//		}
//
//		header('Content-Type: application/json');
//		echo(json_encode($response_data));
//	}
	/**
	 * JSONの出力
	 * @param array $data
	 */
	public function echoJson(array $data)
	{
		header('Content-Type: application/json');
		echo(json_encode($data));
		exit;
	}

}