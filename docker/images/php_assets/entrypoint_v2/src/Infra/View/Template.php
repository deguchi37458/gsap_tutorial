<?php namespace Util\Infra\View;

/**
 * テンプレートと変数の展開をサポートします。
 * 展開される変数はエスケープすることもできます。(デフォルトでは全てエスケープ)
 *
 * @author Vogaro Inc.
 *
 */
class Template
{

    /**
     * @var string ERR_NOT_FOUND_TEMPLATE　テンプレート未検文言
     */
    const ERR_NOT_FOUND_TEMPLATE = '指定のテンプレートファイルが見つかりませんでした。';

    /**
     * 指定のファイルに変数を展開します。
     * テンプレートが見つからない場合InvalidArgumentExceptionが投げられます。
     *
     * @param string $path テンプレートファイル
     * @param array $data　テンプレートに渡すデータ
     * @param bool $escape テンプレートに渡すデータをエスケープするか
     * @param bool $isObgetClean ob_get_cleanによる文字列を取得するかinclude文による戻り値を取得するか
     * @throws \InvalidArgumentException テンプレートが見つからない場合
     * @return string
     */
    public static function load($path, $data = array(), $escape = true, $isObgetClean = true){

        if(file_exists($path) == false){
            throw new \InvalidArgumentException(self::ERR_NOT_FOUND_TEMPLATE . 'ファイル名' . $path);
        }

        if($escape == true){
			extract($data , EXTR_PREFIX_ALL , ""); //エスケープしない変数は$_変数名（例：$a -> $_a）で取得できるように
            $data = static::escape($data);
        }

        ob_start();
        extract($data);
        if($isObgetClean == false){
            return include $path;
        }
        include $path;
        return ob_get_clean();
    }

	/**
     * 再帰的にデータをエスケープする
     * ※scriptタグはエスケープされません。
     *
     * @param mixed $data
     * @return mixed
     */
    public static function escape($data){
        if ( is_array( $data ) ) {
            return array_map( array('self', 'escape'), $data );
        } else {
            if ( gettype( $data ) == "string" ) {
                return htmlspecialchars( $data, ENT_QUOTES );
            } else {
                return $data;
            }
        }
    }

	/**
	 * Twigによるテンプレート読み込み
	 * @param $path
	 * @param $data
	 * @param bool $escape
	 * @return string
	 */
	public static function loadWithTwig($path, $data, $escape = true){
		//twigの設定
		$loader = new \Twig_Loader_Filesystem(pathinfo($path, PATHINFO_DIRNAME));
		$twig   = new \Twig_Environment($loader, ['autoescape' => $escape, 'debug' => true]);
		$twig->addExtension(new \Twig_Extension_Debug());
		return $twig->render(pathinfo($path, PATHINFO_BASENAME), $data);
	}
}