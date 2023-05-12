<?php namespace util\infra\validation;

class Validator{

    /**
     * @var array 検証エラーメッセージ
     */
    protected $err = array();

    /**
     * @var array<Rule> 検証ルール定義インスタンス
     */
    protected $rules = array();

    /**
     * Validatorクラスはmakeメソッドによる起動にする。
     * @return Validator
     */
    public static function make(){ return new self; }

    /**
     * インスタンスの生成はmakeメソッドを使用する。
     */
    protected function __construct(){}

    /**
     * 検証ルールの定義を開始する。
     * @param $key
     * @param $value
     * @param $message
     * @return Rule
     */
    public function set($key, $value, $message)
    {
        $this->rules[$key] = $rule = new Rule($value, $message, $this);

        return $rule;
    }

    /**
     * 検証ルールからエラーメッセージを集める。
     * @return $this
     */
    protected function _fails()
    {
        foreach ($this->rules as $key => $rule){
            $err = $rule->getErr();
            if(!empty($err)){
                $this->err[$key] = $err;
            }
        }

        return $this;
    }

    /**
     * 検証ルールが失敗したかの確認
     * @param string $success
     * @param string $fail
     * @return bool
     */
    public function fails($success = '', $fail = '')
    {
        if(is_callable($success) && is_callable(($fail))){
            return !empty($this->err)?$fail($this->getErr()): $success();
        }

        return !empty($this->err)?true: false;
    }

    /**
     * 設定した内容を元に検証を行う
     * @return $this
     */
    public function valid()
    {
        foreach ($this->rules as $key => $rule){
            $err = $rule->getErr();
            if(!empty($err)){
                $this->err[$key] = $err;
            }
        }

        return $this;
    }

    /**
     * 検証エラーメッセージの取得
     * @return array
     */
    public function getErr()
    {
        return $this->err;
    }

    /**
     * メッセージの設定
     * @param $message
     */
    public function setErrMessage($key, $message)
    {
        $this->err[$key] = $message;
    }

}