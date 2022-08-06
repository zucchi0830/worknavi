<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

// セッション開始
session_start();


// 変数の初期化
$name =
$address_prefectures =
$address_detail =
$homepage =
$full_name =
$email =
$password =
$address_prefectures_key = '';

$errors = [];

$sel_address_prefectures = ['都道府県を選択してください', '青森県', '秋田県', '岩手県', '山形県', '宮城県', '福島県'];
// ログイン判定(ログイン状態なら管理画面へ遷移)
if (isset($_SESSION['current_user'])) {
    header('Location: management.php');
    exit;
}

// ここから
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $name = filter_input(INPUT_POST, 'name');
//     $address_prefectures = filter_input(INPUT_POST, 'address_prefectures');
//     $address_detail = filter_input(INPUT_POST, 'address_detail');
//     $homepage = filter_input(INPUT_POST, 'homepage');
//     $full_name = filter_input(INPUT_POST, 'full_name');
//     $email = filter_input(INPUT_POST, 'email');
//     $password = filter_input(INPUT_POST, 'password');
//     $errors = signup_validate($name, $address_prefectures, $address_detail, $full_name, $email, $password);

//     if (empty($errors)) {
//         insert_company($name, $address_prefectures, $address_detail, $homepage, $full_name, $email, $password);    
//             header('Location: login.php');
//             exit;
//         }
//     }

// ↑ここまで、修正の必要あり?

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name');
    $address_prefectures = filter_input(INPUT_POST, 'address_prefectures');
    $address_detail = filter_input(INPUT_POST, 'address_detail');
    $homepage = filter_input(INPUT_POST, 'homepage');
    $full_name = filter_input(INPUT_POST, 'full_name');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $errors = signup_validate($name, $address_prefectures, $address_detail, $full_name, $email, $password);

    // エラーがなければ登録→ログイン画面へ遷移
    if (empty($errors)) {
        insert_company($name, $address_prefectures, $address_detail, $homepage, $full_name, $email, $password);
        header('Location: signup_confirm.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<!-- ヘッダー読み込み -->
<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>
    <section class="signup_wrapper">
        <h1 class="signup_title">求人掲載までの流れ</h1>
        <ol>
        <li class="nom_li">会社情報を登録する</li>
        <li class="nom_li">ログインし、管理画面へ</li>
        <li class="nom_li">管理画面より、求人掲載ページへ進む</li>
        </ol>
    </section>
    <section class="signup_content wrapper">
        <h1 class="signup_title">会社情報を登録する</h1>
        <?php if ($errors) : ?>
            <ul class="errors">
                <?php foreach ($errors as $error) : ?>
                    <li>
                        <?= h($error) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form class="signup_form" action="" method="post">
            <label class="name_label signup_label" for="name">会社名</label>
            <input type="text" name="name" id="name" placeholder="会社名" value="<?= h($name) ?>">

            <label class="address_prefectures_label signup_label" for="name">本社 都道府県</label>
            <select name="address_prefectures" id="address_prefectures">
                <?php foreach ($sel_address_prefectures as $value) : ?>
                    <?php if ($value === $address_prefectures) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<option value='$value' selected>" . $value . "</option>"; ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<option placeholder='a' value='$value'>" . $value . "</option>"; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>

            <label class="address_detail_label signup_label" for="name">本社 市区町村番地 建物名</label>
            <input type="text" name="address_detail" id="address_detail" placeholder="建物名まで" value="<?= h($address_detail) ?>">

            <label class="url_label  signup_label" for="name">HP URL</label>
            <input type="text" name="homepage" id="homepage" placeholder="HP URL" value="<?= h($homepage) ?>">

            <label class="full_name_label  signup_label" for="full_name">担当者名</label>
            <input type="text" name="full_name" id="full_name" placeholder="担当名" value="<?= h($full_name) ?>">

            <label class="email_label  signup_label" for="email">メールアドレス</label>
            <input type="email" name="email" id="email" placeholder="Email" value="<?= h($email) ?>">

            <label class="password_label  signup_label" for="password">パスワード</label>
            <input type="password" name="password" id="password" placeholder="Password">
            <div class="button_area">

                <input type="submit" value="会社情報を登録する" class="signup_button">
                <a href="login.php" class="login_page_button">ログインはこちら</a>
            </div>
        </form>
    </section>
        <!-- フッター読み込み -->
        <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
