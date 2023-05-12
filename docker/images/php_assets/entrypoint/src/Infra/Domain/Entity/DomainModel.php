<?php namespace util\infra\domain\entity;

/**
 * 汎用Entityクラス
 * Entity,ValueObjectとして値を扱えるようにするクラス。
 * 配列で初期化することができアクセスはメンバを参照する形で可能となります。
 * Class DomainModel
 * @package util\Infra\DDD\DomainModel
 */
abstract class DomainModel extends \ArrayObject
{
    /**
     * id
     */
    const ID = "id";

    /**
     * created
     */
    const CREATED = "created";

    /**
     * modified
     */
    const MODIFIED = "modified";

    /**
     * @var Validator
     */
    protected $validator = 'util\infra\validation\Validator';

    /**
     * @var array DBテーブルと関連するキー一覧を設定
     */
    protected $tableList = array();

    /**
     * ArrayObject::ARRAY_AS_PROPSとしてクラスを初期化
     * @param array|null|object $input
     * @param int $flags
     */
    public function __construct($input = array(), $flags = \ArrayObject::ARRAY_AS_PROPS)
    {
        parent::__construct($input, $flags);
    }

    /**
     * アイテム情報を取得する(連想配列)
     * DBテーブルと関連するキー一覧が設定されていなければ現在ArrayObjectで管理されているデータを取得
     * 設定されていればArrayObjectよりテーブルキーが設定されているもののみ取得
     * @return array
     */
    public function getItem()
    {
        if( empty( $this->tableList ) ){
            return $this->getArrayCopy();
        }

        $_ = array();
        $item = $this->getArrayCopy();
        foreach( $item as $key => $val ){
            if( in_array($key, $this->tableList, true) ){
                $_[$key] = $val;
            }
        }

        return $_;
    }

    /**
     * アイテム情報を取得する(配列・値のみ)
     * DBテーブルと関連するキー一覧が設定されていなければ現在ArrayObjectで管理されているデータを取得
     * 設定されていればArrayObjectよりテーブルキーが設定されているもののみ取得
     * @return array
     */
    public function getItemValues()
    {
        if( empty( $this->tableList ) ){
            return array_values($this->getItem());
        }

        $_ = array();
        $item = $this->getItem();
        foreach( $item as $key => $val ){
            if( in_array($key, $this->tableList, true) ){
                array_push($_, $val);
            }
        }

        return $_;
    }

    /**
     * キー名と?のアイテム情報を取得する(連想配列)
     * DBテーブルと関連するキー一覧が設定されていなければ現在ArrayObjectで管理されているデータを取得
     * 設定されていればArrayObjectよりテーブルキーが設定されているもののみ取得
     * @return array
     */

    public function getItemEscList()
    {
        $conditions = function($key){
            return in_array($key, $this->tableList, true);
        };

        if( empty( $this->tableList ) ){
            $conditions = function($key){
                return true;
            };
        }

        $_ = array();
        $item = $this->getItem();
        foreach( $item as $key => $val ){
            if( $conditions($key) ){
                $_[$key] = "?";
            }
        }

        return $_;
    }

    /**
     * アクセスされたプロパティの値を返す
     * プロパティアクセスで要素が存在しない場合は空文字を返す
     * @param mixed $prop
     * @return mixed|string
     */
    public function offsetGet($prop)
    {
        return !parent::offsetExists($prop)? "":parent::offsetGet($prop);
    }

	/**
	 * 要素を保持しているか判定する
	 * 要素がない場合はfalseを返す
	 * @return boolean
	 */
	function isEmpty(){
		return parent::count() > 0 ? true : false;
	}

    /**
     * IDが存在するか
     * @return bool
     */
    public function isID(){ return !empty($this->id); }

    /**
     * 自身のクラス名を取得
     * @return string
     */
    public function getClass(){ return get_class($this); }

	/**
	 * param情報より新規に自身のインスタンスを作成する
	 * @param array $param
	 * @return mixed
	 */
    public function new_instance( $param = array() )
    {
        $_ = get_class($this);
        return new $_($param);
    }

    /**
     * このEntityの検証処理を開始する
     * @return mixed
     */
    public function validate()
    {
        $validator = new $this->validator($this);
        return $validator->validate();
    }
}