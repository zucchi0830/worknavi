<?php
require_once __DIR__ . '/config.php';

// 接続処理を行う関数
function connect_db()
{
    try {
        return new PDO(
            DSN,
            USER,
            PASSWORD,
            [PDO::ATTR_ERRMODE =>
            PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

// エスケープ処理を行う関数
function h($str)
{
    // ENT_QUOTES: シングルクオートとダブルクオートを共に変換する。
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// エラーメッセージ表示(バリデーション)
function signup_validate($name, $address_prefectures, $address_detail, $homepage, $email, $password)
{
    $errors = [];

    if (empty($name)) {  //会社名
        $errors[] = MSG_NAME_REQUIRED;
    }

    if ($address_prefectures == '都道府県を選択してください') { //都道府県
        $errors[] = MSG_ADDRESS_PREFECTURES;
    }

    if (empty($address_detail)) { //市区町村以降
        $errors[] = MSG_ADDRESS_DETAIL;
    }

    if (empty($email)) { //メールアドレス
        $errors[] = MSG_EMAIL_REQUIRED;
    }

    if (empty($password)) { //パスワード
        $errors[] = MSG_PASSWORD_REQUIRED;
    }


    if (empty($errors) &&
        check_exist_user($email)) { //メールアドレス重複チェック
        $errors[] = MSG_EMAIL_DUPLICATE;
    }
    return $errors;
}

// ユーザー新規登録
function insert_company($name, $address_prefectures, $address_detail, $homepage, $email, $password)
{
    $dbh = connect_db();

    $sql = <<<EOM
    INSERT INTO
        companys
        (name, address_prefectures, address_detail, homepage, email, password)
    VALUES
        (:name, :address_prefectures, :address_detail, :homepage, :email, :password)
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':address_prefectures', $address_prefectures, PDO::PARAM_STR);
    $stmt->bindValue(':address_detail', $address_detail, PDO::PARAM_STR);
    $stmt->bindValue(':homepage', $homepage, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $pw_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindValue(':password', $pw_hash, PDO::PARAM_STR);

    $stmt->execute();
}

// メールアドレス重複チェック
function check_exist_user($email) 
{
    $err = false;
    
    $dbh = connect_db();
    
    $sql = <<<EOM
    SELECT 
        * 
    FROM 
        companys
    WHERE 
        email = :email;
    EOM;
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!empty($user)) {
        $err = true;
    }
    return $err;
}

// ログインエラー(バリデーション)
function login_validate($email, $password)
{
    $errors = [];

    if (empty($email)) {
        $errors[] = MSG_EMAIL_REQUIRED;
    }

    if (empty($password)) {
        $errors[] = MSG_PASSWORD_REQUIRED;
    }

    return $errors;
}

// ログイン機能
function find_user_by_email($email)
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT
        *
    FROM
        companys
    WHERE
        email = :email;
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// お問い合わせフォーム
function contact_validate($name, $full_name, $address_prefectures, $address_detail, $homepage, 
    $tel, $email, $description)
{
    $errors = [];

    if (empty($name)) {  //会社名
        $errors[] = MSG_NAME_REQUIRED;
    }

    if (empty($full_name)) { //氏名
        $errors[] = MSG_FULLNAME_REQUIRED;
    }

    if ($address_prefectures == '都道府県を選択してください') { //都道府県
        $errors[] = MSG_ADDRESS_PREFECTURES;
    }

    if (empty($address_detail)) { //市区町村以降
        $errors[] = MSG_ADDRESS_DETAIL;
    }

    if (empty($tel)) { //電話番号
        $errors[] = MSG_TEL_REQUIRED;
    }

    if (empty($email)) { //メールアドレス
        $errors[] = MSG_EMAIL_REQUIRED;
    }

    return $errors;
}

//お問い合わせ内容登録
function insert_contact($name, $full_name, $address_prefectures, $address_detail, $homepage, 
    $tel, $email, $description)
{
    $dbh = connect_db();

    $sql = <<<EOM
    INSERT INTO
        contacts
        (name, full_name, address_prefectures, address_detail, homepage, tel, email, description)
    VALUES
        (:name, :full_name, :address_prefectures, :address_detail, :homepage, :tel, :email, :description)
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':full_name', $full_name, PDO::PARAM_STR);
    $stmt->bindValue(':address_prefectures', $address_prefectures, PDO::PARAM_STR);
    $stmt->bindValue(':address_detail', $address_detail, PDO::PARAM_STR);
    $stmt->bindValue(':homepage', $homepage, PDO::PARAM_STR);
    $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);

    $stmt->execute();
}
