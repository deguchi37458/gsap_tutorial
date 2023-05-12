<?php namespace Util\Infra\Csv;

use Util\Infra\Http\Request;

/**
 * Class CSV
 * @package Util\Infra\Csv
 */
class CSV
{
    /**
     * CSV constructor.
     * @param $filename ファイル名
     */
    public function __construct($filename)
    {
        $this->setHttpHeader($filename);
        $this->output_csvHeader();
    }

    /**
     * HTTPヘッダーの設定
     * @param $filename ファイル名
     */
    private function setHttpHeader($filename){
        //マック用
        if(Request::ua_mac()){
            header("Content-Disposition: attachment; filename=$filename");
            //IE8以下用
        }else if(1 <= Request::ie_version() && Request::ie_version() <= 8){
            header('Content-Disposition: attachment; filename='.mb_convert_encoding($filename, 'SJIS-win', 'UTF-8'));
            //それ以外はURLエンコードで対応
        }else{
            header('Content-Disposition: attachment; filename*=UTF-8\'\''.rawurlencode($filename));
        }
        header("Content-Type: application/octet-stream");
    }


    /**
     * CSVヘッダー書き出し
     */
    private function output_csvHeader() {
        if(Request::ua_mac()){
            //MAC Excel用のUTF-BOMあり対応
            print("\xEF\xBB\xBF");
        }
    }

    /**
     * 文字コード変換し、書き出し
     * @param array $arr
     * @param string $to_encoding
     * @param string $from_encoding
     */
    public function output_csvBody(array $arr, $to_encoding='', $from_encoding='auto') {
        //文字コードの指定
        if(empty($to_encoding)){
            $to_encoding = $this->getCharaset();
        }

        //指定した文字コードで変換し、書き出し
        if(!empty($arr)){
            mb_convert_variables($to_encoding, $from_encoding, $arr);
            print("\"");
            print(implode("\",\"", $arr));
            print("\"\n");
        }
    }

    /**
     * OSごとの文字コード
     * @return string
     */
    private function getCharaset(){
        //マックの場合はUTF-8
        if(Request::ua_mac()){
            return 'UTF-8';
        }
        return 'SJIS-win';
    }
}
?>