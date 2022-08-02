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

    if (empty($name)) {
        $errors[] = MSG_NAME_REQUIRED;
    }
    if ($address_prefectures == '都道府県を選択してください') {
        $errors[] = MSG_ADDRESS_PREFECTURES;
    }
    if (empty($address_detail)) {
        $errors[] = MSG_ADDRESS_DETAIL;
    }

    if (empty($email)) {
        $errors[] = MSG_EMAIL_REQUIRED;
    }

    if (empty($password)) {
        $errors[] = MSG_PASSWORD_REQUIRED;
    }

    if (empty($errors) &&
        check_exist_user($email)) {
        $errors[] = MSG_EMAIL_DUPLICATE;
    }
    return $errors;
}

// ユーザー新規登録
function insert_user($name, $address_prefectures, $address_detail, $homepage, $email, $password)
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
