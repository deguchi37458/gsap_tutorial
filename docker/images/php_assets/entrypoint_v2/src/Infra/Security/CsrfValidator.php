<?php namespace util\infra\security;

/**
 * Class CsrfValidator
 * @package util\Session
 */
class CsrfValidator
{
    const HASH_ALGO = 'sha256';

    /**
     * 生成
     * @return string
     */
    public static function generate()
    {
        return hash(self::HASH_ALGO, session_id());
    }

    /**
     * 検証
     * @param $token
     * @param bool $throw
     * @return bool
     * @throws InValidCSRFToken
     */
    public static function validate($token, $throw = true)
    {
        $success = self::generate() === $token;
        if (!$success && $throw) {
            throw new InValidCSRFToken('CSRF validation failed.');
        }

        return $success;
    }

}

/**
 * 不正なCSRFトークン
 * Class InValidCSRFToken
 * @package util\Session
 */
class InValidCSRFToken extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }

}