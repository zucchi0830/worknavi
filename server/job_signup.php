<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

// セッション開始
session_start();

if (empty($_SESSION['current_user'])) {
    header('Location: index.php');
    exit;
}
$current_user = $_SESSION['current_user'];

// 変数の初期化
$name = '';
$address_prefectures = '';
$address_detail = '';
$homepage = '';
$email = '';
$password = '';
$address_prefectures_key = '';

$errors = [];

$sel_address_prefectures = ['都道府県を選択してください', '青森県', '秋田県', '岩手県', '山形県', '宮城県', '福島県'];
$sel_employment = ['雇用形態を選択してください','正社員', '契約社員', 'パートアルバイト', 'その他'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name');
    $address_prefectures = filter_input(INPUT_POST, 'address_prefectures');

    $address_detail = filter_input(INPUT_POST, 'address_detail');
    $homepage = filter_input(INPUT_POST, 'homepage');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $errors = signup_validate($name, $address_prefectures, $address_detail, $homepage, $email, $password);

    // エラーがなければ登録→画面偏移
    if (empty($errors)) {
        insert_company($name, $address_prefectures, $address_detail, $homepage, $email, $password);
        header('Location: login.php');
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
        <h1 class="signup_title">求人情報を掲載する</h1>
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
        <!-- ここから求人掲載フォーム -->
            <label class="name_label signup_label" for="name">募集する職種</label>
            <input type="text" name="name" id="name" placeholder="職種名(1つまで)" value="<?= h($name) ?>">

            <label class="address_prefectures_label signup_label" for="name">勤務地 都道府県</label>
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

            <label class="address_detail_label signup_label" for="name">勤務地 市区町村番地 建物名</label>
            <input type="text" name="address_detail" id="address_detail" placeholder="建物名まで" value="<?= h($address_detail) ?>">

            <label class="address_prefectures_label signup_label" for="name">雇用形態</label>
            <select name="address_prefectures" id="address_prefectures">
                <?php foreach ($sel_employment as $employment_value) : ?>
                    <?php if ($employment_value === $sel_employment) : ?>
                        <!--  ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<option value='$employment_value' selected>" . $employment_value . "</option>"; ?>
                    <?php else : ?>
                        <!--  ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<option placeholder='a' value='$employment_value'>" . $employment_value . "</option>"; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>

            <label class="station_label  signup_label" for="email">最寄り駅</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">受動喫煙</label>
            <input type="radio" name="xxx" value="敷地内全面禁煙"> 敷地内全面禁煙
            <input type="radio" name="xxx" value="分煙有り"> 分煙有り

            <label class="station_label  signup_label" for="email">マイカー通勤</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">転勤</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">学歴</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">必要な経験</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">必要な資格・免許</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">給与</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">通勤手当有無</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">通勤手当上限</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">雇用保険加入</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">労災保険加入</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">健康保険加入</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">厚生年金加入</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">育休の取得実績</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">就業時間</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">休憩時間</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">休日</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">休日備考</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">定年制度</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">定年年齢</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">再雇用制度</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">試用期間有無</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">試用期間</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">試用期間中の労働条件相違</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">試用期間中の労働条件詳細</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">仕事内容</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">応募先電話番号</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">電話可能時間</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">応募先メールアドレス</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">
            
            <label class="station_label  signup_label" for="email">応募先担当者名</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <label class="station_label  signup_label" for="email">その他応募方法</label>
            <input type="text" name="email" id="email" placeholder="最寄り駅" value="<?= h($email) ?>">

            <div class="button_area">

                <input type="submit" value="求人情報を掲載する" class="signup_button">
                <a href="login.php" class="login_page_button">ログインはこちら</a>
            </div>
        </form>
    </section>
        <!-- フッター読み込み -->
        <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
