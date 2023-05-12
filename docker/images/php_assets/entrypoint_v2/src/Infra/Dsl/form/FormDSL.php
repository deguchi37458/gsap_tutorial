<?php namespace util\infra\dsl\form;

/**
 * フォームDSL
 * 標準的なフォームのエンジンを構築
 */
class FormDSL
{
    /**
     * @var array index confirm complete
     */
    protected $lazy = array();

    /**
     * トップページ
     */
    const INDEX     = "index";

    /**
     * 確認ページ
     */
    const CONFIRM   = "confirm";

    /**
     * 完了ページ
     */
    const COMPLETE  = "complete";

    /**
     * 検証
     */
    const VALID     = "valid";

    /**
     * 設定
     */
    const SETTING   = "setting";

    /**
     * 特になし
     * FormDSL constructor.
     */
    public function __construct(){}

    /**
     * トップ・確認・完了・検証・設定関数の登録
     * @param $name
     * @param $param
     * @return $this
     */
    public function __call($name, $param)
    {
        $this->lazy[$name] = $param[0];
        return $this;
    }

    /**
     * @param $key
     * @return bool
     */
    public function resolve($key){ return array_key_exists($key, $this->lazy)? $this->lazy[$key]: false; }

    public function run()
    {

        $_ = $this->resolve(self::INDEX);
        $v = array();

        //もとめかた考える
        if( $this->is_post() ){
            $v = call_user_func($this->resolve(self::VALID), $_POST, $this->resolve('setting')->__invoke());
            if(empty($v)){
                if(isset($_POST[self::CONFIRM])){
                    $_ = $this->resolve(self::CONFIRM);
                }else if(isset($_POST[self::COMPLETE])){
                    $_ = $this->resolve(self::COMPLETE);
                }
            }
        }

        $item = $_POST;
        unset($item['confirm']);
        unset($item['complete']);

        call_user_func($_, $item, $err = $v, $this->resolve('setting')->__invoke());
    }

    /**
     * POST通信か判定
     * @return bool
     */
    protected function is_post()
    {
        return $_SERVER["REQUEST_METHOD"] == "POST";
    }

}