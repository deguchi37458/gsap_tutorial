<?php namespace util\infra\domain\entity;
use util\context\form\entity\FormItemEntity;

/**
 * 基本検索オブジェクト
 * 検索条件をクラスとして扱いたい場合、このクラスを継承してください。
 * Class ConditionObject
 * @package Context\CMS\Base\Domain\Entity
 */
abstract class ConditionObject
{
    /**
     * ID
     */
    const KEY_ID                    = 'id';
    /**
     * ページ
     */
    const KEY_PAGE                  = 'page';

    /**
     * 取得件数
     */
    const KEY_LIMIT                 = 'limit';

    /**
     * ソート列
     */
    const KEY_SORT_COLUMN            = 'sort_column';

    /**
     * ソート順
     */
    const KEY_SORT_DIRECTION         = 'sort_direction';

    /**
     * @var int id
     */
    public $id              = 0;

    /**
     * @var int 取得件数
     */
    public $limit           = 10;

    /**
     * @var string ソート列
     */
    public $sort_column     = FormItemEntity::CREATED;

    /**
     * @var string ソート順
     */
    public $sort_direction  = "DESC";

    /**
     * @var string ページ数
     */
    public $page            = "1";

    /**
     * @var
     */
    protected $entity = 'util\infra\domain\entity\DomainModel';

    /**
     * ConditionObject constructor.
     * @param array $conditions
     */
    public function __construct(array $conditions = array())
    {
        $this->setData($conditions);
    }

    /**
     * プロパティのゲッター
     * @param $key
     * @param string $default
     * @return string
     */
    public function get($key, $default = '')
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }
        return $default;
    }

    /**
     * 合計数を取得
     * @return int
     */
    public function maxResults(){ return $this->limit * $this->page; }

    /**
     * 連想配列よりクラスのメンバに値を設定します。
     * @param $conditions
     */
    public function setData($conditions)
    {
        if( empty($conditions) )return;

        foreach( $conditions as $key => $value ){
            if( property_exists($this, $key) ){
                $this->$key = $value;
            }
        }

    }

    /**
     * このクラスに静的に紐付いているEntityクラスの取得
     * @return DomainModel
     */
    public function relationEntity()
    {
        return $this->entity;
    }

}