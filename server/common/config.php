<?php
// 接続に必要な情報を定数として定義
define('DSN', 'mysql:host=db;dbname=worknavi;charset=utf8');
define('USER', 'master_user');
define('PASSWORD', 'Panda1bias');

define('EXTENTION', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

define('MSG_NAME_REQUIRED', '会社名を入力してください');
define('MSG_ADDRESS_PREFECTURES_REQUIRED', '都道府県を選択してください');
define('MSG_ADDRESS_DETAIL_REQUIRED', '市区町村番地 建物名を入力してください');
define('MSG_EMAIL_REQUIRED', 'メールアドレスを入力してください');
define('MSG_PASSWORD_REQUIRED', 'パスワードを入力してください');
define('MSG_FULLNAME_REQUIRED', '氏名を入力してください');
define('MSG_TEL_REQUIRED', '電話番号を入力してください');
define('MSG_EMAIL_DUPLICATE', 'このメールアドレスは既に会員登録されています');
define('MSG_EMAIL_PASSWORD_NOT_MATCH', 'メールアドレスかパスワードが間違っています');

//求人掲載バリデーション(都道府県,市区町村,メールアドレス,電話番号は↑を使う)22項目
define('MSG_TYPE_REQUIRED', '職種を入力してください');
define('MSG_EMPLOYMENT_REQUIRED', '雇用形態を選択してください');
define('MSG_STATION_REQUIRED', '最寄り駅を入力してください');
define('MSG_SMOKE_REQUIRED', '受動喫煙対策を選択してください');
define('MSG_COMMUTE_REQUIRED', 'マイカー通勤を選択してください');
define('MSG_TRANSFER_REQUIRED', '転勤の有無を選択してください');
define('MSG_ACADEMIC_REQUIRED', '必要学歴を選択してください');
define('MSG_SALARY_REQUIRED', '給与を入力してください');
define('MSG_ALLOWANCE_REQUIRED', '通勤手当有無を選択してください');
define('MSG_ALLOWANCE_LIMIT_REQUIRED', '通勤手当上限を入力してください');
define('MSG_INSURANCES_REQUIRED', '社会保険を選択してください');
define('MSG_CHILDCARE_LEAVE_REQUIRED', '育休の取得実績有無を選択してください');

define('MSG_WORK_HOURS_REQUIRED', '就業時間を入力してください');
define('MSG_BREAK_TIME_REQUIRED', '休憩時間を入力してください');
define('MSG_HOLIDAY_REQUIRED', '休日を入力してください');
define('MSG_HOLIDAY_DETAIL_REQUIRED', '休日詳細を入力してください'); //休日が「その他」の場合
define('MSG_RETIREMENT_REQUIRED', '定年制度を選択してください');
define('MSG_RETIREMENT_REMARKS_REQUIRED', '定年年齢を入力してください'); //定年制度「有」の場合
define('MSG_REHIRE_REQUIRED', '再雇用制度を選択してください');
define('MSG_TRIAL_PERIOD_REQUIRED', '試用期間有無を選択してください');
define('MSG_TRIAL_PERIOD_SPAN_REQUIRED', '試用期間を入力してください'); //試用期間「有」の場合
define('MSG_TRIAL_PERIOD_CONDITIONS_REQUIRED', '試用期間中の労働条件相違を選択してください');
define('MSG_TRIAL_PERIOD_CONDITIONS_DETAIL_REQUIRED', '試用期間中の労働条件詳細を入力してください');
define('MSG_DESCRIPTION_REQUIRED', '仕事内容を入力してください');

define('MSG_E_TEL_TIME_REQUIRED', '電話可能時間を入力してください'); 
define('MSG_E_NAME_REQUIRED', '採用担当者名を入力してください');

define('MSG_NO_JOB_TITLE', '求人タイトルを入力してください');
define('MSG_NO_DESCRIPTION', '詳細を入力してください');
define('MSG_NO_IMAGE', '画像を選択してください');
define('MSG_NOT_ABLE_EXT', '選択したファイルの拡張子が有効ではありません');
