<?php
// 接続に必要な情報を定数として定義
define('DSN', 'mysql:host=db;dbname=worknavi;charset=utf8');
define('USER', 'master_user');
define('PASSWORD', 'Panda1bias');

define('MSG_NAME_REQUIRED', '会社名が未入力です');
define('MSG_ADDRESS_PREFECTURES', '本社 都道府県を選択してください');
define('MSG_ADDRESS_DETAIL', '本社 市区町村番地 建物名が未入力です');
define('MSG_EMAIL_REQUIRED', 'メールアドレスが未入力です');
define('MSG_PASSWORD_REQUIRED', 'パスワードが未入力です');
define('MSG_EMAIL_DUPLICATE', 'このメールアドレスは既に会員登録されています');
