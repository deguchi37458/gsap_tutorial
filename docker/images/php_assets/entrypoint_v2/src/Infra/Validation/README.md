### 検証ライブラリ

汎用的な検証用のルールとそれを管理するための機能を提供します。

## サンプル

### 基本

```
#!php

<?php
use JP\Grampus\Validation\Validator;


//ダミーデータ
$q = array(
  'name'      => 'vogaro',
  'password'  => 'hogehoge',
  'email'     => 'hogehoge@vogaro.co.jp'
);

//検証クラスの初期化
$validator = Validator::make();

//nameを必須項目・長さを255以下に設定
$validator->set($q['name'], 'お名前')->required()->length('>', 255, 'は255文字以内で入力してください。')->end();

//パスワードを必須に設定
$validator->set($q['password'], 'パスワード')->required()->end();

//メールアドレスの書式を確認
$validator->set($q['email'], 'メールアドレス')->email()->required()->end();

//設定したルールに基づき検証を開始
$validator->valid();

//検証ルールに失敗したか
if($validator->fails() == true){
  //失敗したならエラーメッセージを取得
  $err = $validator->getErr();
}

```

### DSL風

```
#!php

<?php
use JP\Grampus\Validation\Validator;


//ダミーデータ
$q = array(
  'name'      => 'vogaro',
  'password'  => 'hogehoge',
  'email'     => 'hogehoge@vogaro.co.jp'
);

$isFails = Validator::make()

->set($q['name'], 'お名前')
->required()
->length('>', 255, 'は255文字以内で入力してください。')
->end()

->set($q['password'], 'パスワード')
->required()
->end()

>set($q['email'], 'メールアドレス')
->email()
->required()
->end();

->valid()
->fails();

```

### required($message = 'が入力されていません。')
値か設定されていることを検証する。
nullか文字列なら空文字でないか配列なら要素があるかで判定する。

```
#!php

<?php
use JP\Grampus\Validation\Validator;

//ダミーデータ
$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')->required()->end();
//エラーメッセージ　会社名が入力されていません。
```

### numeric($message = 'の値が数値ではありません。')
値が数値のみであることを検証する(16進数, 10進数, 8進数, 2進数, 浮動少数, 整数)

```
#!php

<?php
use JP\Grampus\Validation\Validator;

//ダミーデータ
$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> numeric()->end();

```

### degit($message = 'の値が数値ではありません。')
値が数値のみであることを検証する(10進数)

```
#!php

<?php
use JP\Grampus\Validation\Validator;

//ダミーデータ
$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> degit()->end();

```

### alpha($message = 'の値が半角英字のみではありません。')
値がアルファベットのみであることを検証する

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> alpha()->end();

```

### alphaNumeric($message = 'の値が半角英数字のみではありません。')
値がアルファベットと数値のみであることを検証する

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> alphaNumeric()->end();

```


### tel($message = 'の書式が正しくありません。')
電話番号であることを検証する。

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> tel()->end();

```

### email($message = 'の書式が正しくありません。')
メールアドレスであることを確認する

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> email()->end();

```

### ip($message = 'の値は正しいIPではありません。')
IPアドレスであることを検証する

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> ip()->end();

```

### url($message = 'の値は正しいURLではありません。')
urlであることを検証する

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> ip()->end();

```

### dateFormat($message = '日付の書式が正しくありません。')
値が日付であることを検証する

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> dateFormat()->end();

```

### same($target, $message = 'は同じではありません。')
指定した値と等しいか検証する。

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> same()->end();

```

### zenkaku($message = 'に全角文字以外が含まれています。')
値が全角文字であることを検証する

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> zenkaku()->end();

```

### hiragana($message = 'にひらがな以外が含まれています。')
値が全角ひらがなであることを確認する

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> hiragana()->end();

```

### length($operator, $len, $message = '', $encoding = 'UTF-8')
値の長さを検証する

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> hiragana()->end();

```

### tokenIOS($message = 'IOSのデバイストークンが不正です。')

デバイストークンチェック(IOS)

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> tokenIOS()->end();

```

### tokenAndroid($message = 'Androidのデバイストークンが不正です。')

デバイストークンチェック (Android)

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> tokenAndroid()->end();

```

### custom($callback, $message)

独自関数を定義して登録することも可能。

無名関数による登録

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> custom(function(){
	return true;
}, 'カスタムメッセージ')->end();

```

名前付き関数による登録

```
#!php

<?php
use JP\Grampus\Validation\Validator;

$q = array(
  'name'      => 'Vogaro株式会社',
);

$custom = function($v){
	return true;
}

$validator = Validator::make();
$validator->set($q['name'], '会社名')-> custom($custom, 'カスタムメッセージ')->end();

```