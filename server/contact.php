<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

// セッション開始
session_start();

// 変数の初期化
$name = '';
$full_name = '';
$address_prefectures = '';
$address_detail = '';
$homepage = '';
$tel = '';
$email = '';
$description = '';
$address_prefectures_key = '';

$errors = [];

$sel_address_prefectures = [
    '都道府県を選択してください', '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県',
    '福島県', '茨城県', '栃木県', '群馬県',
    '埼玉県', '千葉県', '東京都', '神奈川県',
    '新潟県', '富山県', '石川県', '福井県',
    '山梨県', '長野県',
    '岐阜県', '静岡県', '愛知県', '三重県',
    '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県',
    '鳥取県', '島根県', '岡山県', '広島県', '山口県',
    '徳島県', '香川県', '愛媛県', '高知県',
    '福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name');
    $full_name = filter_input(INPUT_POST, 'full_name');
    $address_prefectures = filter_input(INPUT_POST, 'address_prefectures');
    $address_detail = filter_input(INPUT_POST, 'address_detail');
    $homepage = filter_input(INPUT_POST, 'homepage');
    $tel = filter_input(INPUT_POST, 'tel');
    $email = filter_input(INPUT_POST, 'email');
    $description = filter_input(INPUT_POST, 'description');
    
    $errors = contact_validate($name, $full_name, $address_prefectures, $address_detail, $homepage, 
    $tel, $email, $description);

    // エラーがなければ登録→画面偏移
    if (empty($errors)) {
        insert_contact($name, $full_name, $address_prefectures, $address_detail, $homepage, 
    $tel, $email, $description);
        header('Location: contact_confirm.php');
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
    <section class="signup_content wrapper">
        <h1 class="signup_title">お問い合わせ</h1>
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

            <label class="full_name_label signup_label" for="full_name">氏名</label>
            <input type="text" name="full_name" id="full_name" placeholder="氏名" value="<?= h($full_name) ?>">

            <label class="address_prefectures_label signup_label" for="address_prefectures">都道府県</label>
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

            <label class="address_detail_label signup_label" for="address_detail">市区町村番地 建物名</label>
            <input type="text" name="address_detail" id="address_detail" placeholder="建物名まで" value="<?= h($address_detail) ?>">

            <label class="homepage_label signup_label" for="homepage">HP URL</label>
            <input type="text" name="homepage" id="homepage" placeholder="HP URL" value="<?= h($homepage) ?>">

            <label class="tel_label signup_label" for="tel">電話番号</label>
            <input type="tel" name="tel" id="tel" placeholder="tel" maxlength="13" value="<?= h($tel) ?>">

            <label class="email_label signup_label" for="email">メールアドレス</label>
            <input type="email" name="email" id="email" placeholder="Email" value="<?= h($email) ?>">

            <label class="description_label signup_label" for="description">お問い合わせ内容</label>
            <textarea class="description" name="description" rows="5" maxlength="1000" placeholder="お問い合わせ内容を入力してください"><?= h($description) ?></textarea>
            
            <div class="button_area">
                <input type="submit" value="上記内容で問い合わせる" class="contact_button">
            </div>
        </form>
    </section>
        <!-- フッター読み込み -->
        <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
