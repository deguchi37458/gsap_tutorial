### フォームライブラリ

フォームの各画面遷移(トップ・確認・完了)の遷移をサポートします。

## サンプル

### 基本

```
#!php

<?php namespace infoform;
require_once(dirname(__FILE__) . '/vendor/autoload.php');

/**
 * FormDSLクラスをインスタンス化し、各フォーム画面で処理する場所を用意します。
 */
return with(new FormDSL())
    /**
     * index,confirm,complete画面で$setting変数としてアクセスできるようになります。
     * フォーム全体の設定値などで使用します。
     */
    ->setting(function(){
        return array();
    })
    
    /**
     * $qはフォームから送信されたきた値になり、この値を使用してフォーム値の検証処理を行います。
     * 確認画面・完了画面に遷移する場合にここに処理が入ります。
     * 戻り値をfalseの判定になるようなものを返すと次の確認画面に進みます。
     */
    ->valid(function($q){
        
    })

    /**
     * トップページの処理を記述します。
     */
    ->index(function($query, $err, $setting){
    
    })

    /**
     * 確認画面での処理を記述します。
     */
    ->confirm(function($query, $err, $setting){
        
    })

    /**
     * 完了画面での処理を記述します。
     */
    ->complete(function($item, $err, $setting){

    })

    /**
     * 各メソッドて定義された内容を元にシステムを起動します。
     */
    ->run();
    
```



### フォームのサンプルコード

導入サイト・[ユーセイフォーム](https://yusei-az.co.jp/form/)

```
#!php


<?php namespace infoform;
require_once(dirname(__FILE__) . '/../lacne/Base/system/class/bootstrap.php');

/**========================
 * 資料請求フォーム
 *========================*/

use util\View\Template;
use util\Validation\Validator;
use util\dsl\form\FormDSL;
use Context\Article\service\ObjectEntityKey;
use Context\Contact\MailFactory;
use Context\Contact\FormModel;
use util\Util\Bag;

/**
 * フォームのname一覧
 * Class FormName
 * @package infoform
 */
class FormName
{
    const PROPERTY_LIST     = 'property-list';
    const PROPERTY_ID       = 'property-id';
    const PROPERTY_TITLE    = 'property-title';
    const HOPE_AREA         = 'hope-area';
    const HOPE_WAYSIDE      = 'hope-wayside';
    const LAST_NAME         = 'last-name';
    const FIRST_NAME        = 'first-name';
    const LAST_NAME_KANA    = 'last-name-kana';
    const FIRST_NAME_KANA   = 'first-name-kana';
    const TEL1              = 'tel1';
    const TEL2              = 'tel2';
    const TEL3              = 'tel3';
    const ZIP1              = 'zip1';
    const ZIP2              = 'zip2';
    const PREF              = 'pref';
    const ADD               = 'add';
    const ADDRESS_OTHER     = 'address-other';
    const EMAIL             = 'email';
    const EMAIL_CONFIRM     = 'email-confirm';
    const MOBILE_EMAIL      = 'mobile-email';
    const REMARK            = 'remark';
    const LIVING_STYLE      = 'living-style';
    const SELF_FUND         = 'self-fund';
    const ANNUAL_INCOME     = 'annual-income';
    const CURRENT_RENT      = 'current-rent';
    const WHEN_BUY          = 'when-buy';
    const CONTACT_BUY       = 'contact-by';
    const TRIGGER           = 'trigger';
}

/**
 * フォーム処理の定義を記述
 */
return with(new FormDSL())
    /**
     * 特になし。
     */
    ->setting(function(){
        return array();
    })
    /**
     * フォームの値の検証設定を定義
     */
    ->valid(function($q){
        return Validator::make()

        ->set($q[FormName::PROPERTY_LIST], '', FormName::PROPERTY_LIST) //資料請求される物件名・ID
        ->required('必須項目です。')->end()

        ->set($q[FormName::PROPERTY_TITLE], '', FormName::PROPERTY_TITLE) //資料請求される物件名
        ->required('必須項目です。')->end()

        ->set($q[FormName::HOPE_AREA], 'ご希望のエリア', FormName::HOPE_AREA) //ご希望のエリア
        ->end()

        ->set($q[FormName::HOPE_WAYSIDE], 'ご希望の沿線', FormName::HOPE_WAYSIDE) //ご希望の沿線
        ->end()

        ->set($q[FormName::LAST_NAME], '', FormName::LAST_NAME) //姓
        ->required('必須項目です。')->end()

        ->set($q[FormName::FIRST_NAME], '', FormName::FIRST_NAME) //名
        ->required('必須項目です。')->end()

        ->set($q[FormName::LAST_NAME_KANA], '', FormName::LAST_NAME_KANA) //セイ
        ->katakana('カタカナで入力してください。')->required('必須項目です。')->end()

        ->set($q[FormName::FIRST_NAME_KANA], '', FormName::FIRST_NAME_KANA) //メイ
        ->katakana('カタカナで入力してください。')->required('必須項目です。')->end()

        ->set($q[FormName::TEL1], '', FormName::TEL1) //電話番号1
        ->degit('数値で入力してください。')->required('必須項目です。')->end()

        ->set($q[FormName::TEL2], '', FormName::TEL2) //電話番号2
        ->degit('数値で入力してください。')->required('必須項目です。')->end()

        ->set($q[FormName::TEL3], '', FormName::TEL3) //電話番号3
        ->degit('数値で入力してください。')->required('必須項目です。')->end()

        ->set($q[FormName::ZIP1], '', FormName::ZIP1) //郵便番号1
        ->degit('数値で入力してください。')->required('必須項目です。')->end()

        ->set($q[FormName::ZIP2], '', FormName::ZIP2) //郵便番号2
        ->degit('数値で入力してください。')->required('必須項目です。')->end()

        ->set($q[FormName::PREF], '', FormName::PREF) //都道府県
        ->required('必須項目です。')->end()

        ->set($q[FormName::ADD], '', FormName::ADD) //市区町村
        ->required('必須項目です。')->end()

        ->set($q[FormName::ADDRESS_OTHER], '', FormName::ADDRESS_OTHER) //以降の住所
        ->required('必須項目です。')->end()

        ->set($q[FormName::EMAIL], '', FormName::EMAIL)
        ->email('書式が正しくありません。')->required('必須項目です。')->end()

        ->set($q[FormName::EMAIL_CONFIRM], '', FormName::EMAIL_CONFIRM)
        ->custom(function($v) use($q){

            if( empty( $q['email'] ) ){
                return false;
            }

            return $v != $q['email'];
        }, 'PCメールアドレスとPCメールアドレス(確認)が一致しません。')
        ->email('書式が正しくありません。')->required('必須項目です。')->end()

        ->set($q[FormName::MOBILE_EMAIL], '', FormName::MOBILE_EMAIL)
        ->email('書式が正しくありません。')->end()

        ->set($q[FormName::REMARK], 'ご希望・ご質問', FormName::REMARK) //ご希望・ご質問
        ->end()

        //以下アンケート
        ->set($q[FormName::LIVING_STYLE], '現在のお住まい(形態)', FormName::LIVING_STYLE)
        ->end()

        ->set($q[FormName::SELF_FUND], '自己資金', FormName::SELF_FUND)
        ->end()

        ->set($q[FormName::ANNUAL_INCOME], '年収', FormName::ANNUAL_INCOME)
        ->end()

        ->set($q[FormName::CURRENT_RENT], '現在の家賃', FormName::CURRENT_RENT)
        ->end()

        ->set($q[FormName::WHEN_BUY], '購入予定時期', FormName::WHEN_BUY)
        ->end()

        ->set($q[FormName::CONTACT_BUY], '情報配信方法', FormName::CONTACT_BUY)
        ->end()

        ->set($q[FormName::TRIGGER], 'サイトをお知りになった場所', FormName::TRIGGER)
        ->end()

        //検証の設定項目を評価しエラー内容を返却
        ->valid()->getErr();
    })

    /**
     * トップページ
     */
    ->index(function($query, $err, $setting){
        global $_LACNE_CONFIG;

        if(with(new FormModel()) -> existProperty($_GET['id'], ObjectEntityKey::IS_CONTACT_INFORMATION))
        {
            $propertylist =  with(new FormModel()) -> getPropertyName($_GET['id'], ObjectEntityKey::IS_CONTACT_INFORMATION);
        }

        echo( Template::load(dirname(__FILE__) . '/tmpl/index.php', array(
            //エラーメッセージ
            'err'                           => new Bag($err),
            // フォーム項目の設定値を定義
            'setting'                       => array(
                    'property-list'         => with(new FormModel()) -> getPropertyList(),
                    'hope-area'             => array('寝屋川市', '枚方市', '交野市', '吹田市', '豊中市', '大阪市', '大阪府その他', '京都市', '向日市', '京都府その他', '西宮市', '兵庫県その他', 'その他'),
                    'hope-wayside'          => array('京阪線', 'JR学研都市線', 'JR京都線', 'JR奈良線', '阪急千里線', '阪急京都線', '阪急神戸線', '近鉄京都線', '近鉄奈良線', '阪神線', '大阪モノレール', '大阪市営地下鉄', 'その他'),
                    'pref'                  => $_LACNE_CONFIG['prefs'],
                    'living-style'          => array('選択する', '持家', '賃貸', '親と同居', 'その他'),
                    'self-fund'             => array('選択する', '無', '～100万円', '～300万円', '～500万円', '～700万円', '～900万円', '1000万円～'),
                    'annual-income'         => array('選択する', '300万円未満', '300～400万円', '400～500万円', '500～600万円', '600～700万円', '700～800万円', '800～1000万円', '1000万円以上'),
                    'current-rent'          => array('選択する', '3万円未満', '3～4万円', '4～5万円', '5～6万円', '6～7万円', '7～8万円', '8～9万円', '9～10万円', '10～11万円', '11～12万円', '12万円以上', '無'),
                    'when-buy'              => array('選択する', '早急', '6ヶ月以内', '1年以内', '2年以内', '良いものがあれば', 'その他'),
                    'contact-by'            => array('メール', '電話', '郵送', '訪問'),
                    'trigger'               => array('選択する', '折込チラシ', '情報誌ぱど', 'リビング新聞', 'ポスティング', '自社HP', 'SUUMO', 'ホームズ', 'オウチーノ', 'Yahoo不動産', 'アットホーム', 'Shufoo!（シュフー）', 'FM802(ラジオ)', 'DM', '看板', '駅看板', 'ユーセイ物件購入者の紹介', '知人からの情報', '現地を見て', '家が近所', '実家が近所', '市役所（所内モニター広告）', '市役所（HPバナー広告）', 'その他')
            ),
            //フォーム項目の初期化
            'item' => empty($query)?
                array(
                    'property-list'         => $propertylist, //資料請求される物件名
                    'hope-area'             => '', //ご希望のエリア
                    'hope-wayside'          => '', //ご希望の沿線
                    'last-name'             => '', //姓
                    'first-name'            => '', //名
                    'last-name-kana'        => '', //セイ
                    'first-name-kana'       => '', //メイ
                    'tel1'                  => '', //電話番号1
                    'tel2'                  => '', //電話番号2
                    'tel3'                  => '', //電話番号3
                    'zip1'                  => '', //郵便番号1
                    'zip2'                  => '', //郵便番号2
                    'pref'                  => '', //都道府県
                    'add'                   => '', //市区町村
                    'address-other'         => '', //それ以降の住所
                    'email'                 => '', //PCメールアドレス
                    'email-confirm'         => '', //PCメールアドレス(確認)
                    'mobile-email'          => '', //メールアドレス
                    'remark'                => '', //ご希望・ご質問
                    'living-style'          => '', //現在のお住まい(形態)
                    'self-fund'             => '', //自己資金
                    'annual-income'         => '', //年収
                    'current-rent'          => '', //現在の家賃
                    'when-buy'              => '', //購入予定時期
                    'contact-by'            => '', //情報配信方法
                    'trigger'               => '', //サイトをお知りになった場所
                    'property-id'           =>array(),
                    'property-title'        =>array()
                ): $query
        ))
        );
    })

    /**
     * 確認画面
     */
    ->confirm(function($query, $err, $setting){
        echo( Template::load(dirname(__FILE__) . '/tmpl/confirm.php', array('item' => $query)) );
    })

    /**
     * 完了画面
     */
    ->complete(function($item, $err, $setting){

        $admin_mail = "wakai@vogaro.co.jp";
        //$admin_mail = "info@yusei-az.co.jp";

        /**============================
         * 管理者に送信
         *============================*/
        //メール本文の作成
        $object_id_list = with(new FormModel()) -> getObjectIdList($item['property-id']); //この物件の物件ID取得

        $mailBody = Template::load(dirname(__FILE__) . '/tmpl/email_admin.php', array(
         //メールテンプレートに必要な情報を設定
        'property_list'         => $item['property-list'],
        'hope_area'             => $item['hope-area'],
        'hope_wayside'          => $item['hope-wayside'],
        'last_name'             => $item['last-name'],
        'first_name'            => $item['first-name'],
        'last_name_kana'        => $item['last-name-kana'],
        'first_name_kana'       => $item['first-name-kana'],
        'tel1'                  => $item['tel1'],
        'tel2'                  => $item['tel2'],
        'tel3'                  => $item['tel3'],
        'zipcode1'              => $item['zip1'],
        'zipcode2'              => $item['zip2'],
        'pref'                  => $item['pref'],
        'add'                   => $item['add'],
        'address_other'         => $item['address-other'],
        'email'                 => $item['email'],
        'email_confirm'         => $item['email-confirm'],
        'mobile_email'          => $item['mobile-email'],
        'remark'                => $item['remark'],
        'living_style'          => $item['living-style'],
        'self_fund'             => $item['self-fund'],
        'annual_income'         => $item['annual-income'],
        'current_rent'          => $item['current-rent'],
        'when_buy'              => $item['when-buy'],
        'contact_by'            => $item['contact-by'],
        'trigger'               => $item['trigger'],
        'object_id_list'        => $object_id_list,
        ), true, true);

        //管理者に送信
        with(new MailFactory()) -> send($admin_mail, "【資料請求】お問い合わせがありました。", $mailBody, $admin_mail, $cc = array());

        /**============================
         * ユーザに送信
         *============================*/

        //メール本文の作成
        $mailBody = Template::load(dirname(__FILE__) . '/tmpl/email_user.php', array(
            //メールテンプレートに必要な情報を設定
            'property_list'         => $item['property-list'],
            'hope_area'             => $item['hope-area'],
            'hope_wayside'          => $item['hope-wayside'],
            'last_name'             => $item['last-name'],
            'first_name'            => $item['first-name'],
            'last_name_kana'        => $item['last-name-kana'],
            'first_name_kana'       => $item['first-name-kana'],
            'tel1'                  => $item['tel1'],
            'tel2'                  => $item['tel2'],
            'tel3'                  => $item['tel3'],
            'zipcode1'              => $item['zip1'],
            'zipcode2'              => $item['zip2'],
            'pref'                  => $item['pref'],
            'add'                   => $item['add'],
            'address_other'         => $item['address-other'],
            'email'                 => $item['email'],
            'email_confirm'         => $item['email-confirm'],
            'mobile_email'          => $item['mobile-email'],
            'remark'                => $item['remark'],
            'living_style'          => $item['living-style'],
            'self_fund'             => $item['self-fund'],
            'annual_income'         => $item['annual-income'],
            'current_rent'          => $item['current-rent'],
            'when_buy'              => $item['when-buy'],
            'contact_by'            => $item['contact-by'],
            'trigger'               => $item['trigger'],
            'object_id_list'        => $object_id_list,
        ), true, true);

        //ユーザに送信
        with(new MailFactory()) -> send($item['email'], "【ユーセイ物件資料】をご請求いただきありがとうございます。", $mailBody, $admin_mail, $cc = array());
        header('location: thanks.php');
        exit;
    })

    /**
     *  システムの起動
     */
    ->run();



```
