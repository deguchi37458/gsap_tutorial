<?php namespace util\infra\http;
/**
 * Class Request
 * @package util\infra\http
 */

class Request
{
    /**
     * @return bool
     */
    public static function ua_mac()
    {
        return preg_match('/Macintosh/', $_SERVER['HTTP_USER_AGENT'])? true: false;
    }

    /**
     * @return int
     */
    public static function ie_version()
    {
        if(!stristr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
            $ver = 0;
        } else {
            preg_match('/MSIE\s([\d.]+)/i', $_SERVER['HTTP_USER_AGENT'], $ver);
            $ver = floor($ver[1]);
        }

        return (int) $ver;
    }
}