<?php
$job_address_prefectures = ['都道府県を選んでください', '青森県', '秋田県', '岩手県', '山形県', '宮城県','福島県'];
$job_employment = ['正社員', '契約社員', 'パート・アルバイト', 'その他'];
$job_academic = ['大学卒', '高校卒', '中学卒', '不問'];
$job_holiday = ['日','月','火','水','木','金','土','祝','その他']

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 会社名
    $company = filter_input(INPUT_POST, 'company');
    // 本社都道府県
    $company_address = filter_input(INPUT_POST, 'company_address');
    // 本社 市区町村番地 建物名
    $description = filter_input(INPUT_POST, 'company');
}
?>

<!DOCTYPE html>
<html lang="ja">
<!-- ヘッダー読み込み -->
<?php include_once __DIR__ . '/_head.php' ?>
<?php include_once __DIR__ . '/_header.php' ?>

<body>
    <div class="signup_container">
        <h1 class="signup_sub_title">無料で求人掲載</h1>
        <div class="job_form">
            会社名
            <input type="text" name="company" placeholder="会社名をご入力ください">
        </div>
        本社 都道府県
        <select name="company_address" id="type">
            <?php foreach ($job_address_prefectures as $prefectures_key) :
                echo '<option value="' . $prefectures_key . '">' . $prefectures_key . '</option>';
            endforeach; ?>
        </select>
        <div class="job_form">
            本社 市区町村番地 建物名
            <input type="text" name="company" placeholder="市区町村番地 建物名をご入力ください">
        </div>
        <div class="job_form">
            職種
            <input type="text" name="tel" placeholder="職種名をご入力ください">
        </div>
        <div class="job_form">
            勤務地 都道府県
            <select name="item" id="type">
                <?php foreach ($job_address_prefectures as $prefectures_key) :
                    echo '<option value="' . $prefectures_key . '">' . $prefectures_key . '</option>';
                endforeach; ?>
            </select>
        </div>
        <div class="job_form">
            勤務地 市区町村番地
            <input type="text" name="tel" placeholder="市区町村番地 建物名をご入力ください">
        </div>
        <div class="job_form">
            雇用形態
                <?php foreach ($job_employment as $employment_key) :
                    echo '<input type="radio" value="' . $employment_key . '">' . $employment_key . ' ' . '</option>';
                endforeach; ?>
        </div>
        <div class="job_form">
            最寄り駅
            <input type="text" name="email" placeholder="最寄り駅をご入力ください">
        </div>
        <div class="job_form">
            受動喫煙対策
<input type="radio" name="xxx" value="敷地内全面禁煙"> 敷地内全面禁煙
<input type="radio" name="xxx" value="分煙有り"> 分煙有り
        </div>
        <div class="job_form">
            マイカー通勤
<input type="radio" name="xxx" value="可(駐車場有)"> 可(駐車場有)
<input type="radio" name="xxx" value="可(駐車場無)"> 可(駐車場無)
<input type="radio" name="xxx" value="バイク可"> バイク可
<input type="radio" name="xxx" value="不可"> 不可
        </div>
        <div class="job_form">
            転勤の可能性
<input type="radio" name="xxx" value="有"> 有
<input type="radio" name="xxx" value="無"> 無
        </div>
        <div class="job_form">
            求める最終学歴
                <?php foreach ($job_academic as $academic_key) :
                    echo '<input type="radio" value="' . $academic_key . '">' . $academic_key . ' ' . '</option>';
                endforeach; ?>
        </div>
        <div class="job_form">
            必要な経験
            <input type="text" name="email" placeholder="必要な経験をご入力ください">
        </div>
        <div class="job_form">
            必要な資格・免許
            <input type="text" name="email" placeholder="必要な資格・免許をご入力ください">
        </div>
        <div class="job_form">
            給与
            <input type="text" name="email" placeholder="給与をご入力ください">
        </div>
        <div class="job_form">
            通勤手当 実費支給
<input type="radio" name="xxx" value="有"> 有
<input type="radio" name="xxx" value="無"> 無
        </div>
        <div class="job_form">
            上限有無
<input type="radio" name="xxx" value="有"> 有
<input type="radio" name="xxx" value="無"> 無
        </div>
        <div class="job_form">
            上限
            <input type="text" name="email" placeholder="上限額をご入力ください">
        </div>
        <div class="job_form">
            加入保険
            <input type="checkbox" name="xxx" value="雇用保険"> 雇用保険
            <input type="checkbox" name="xxx" value="労災保険"> 労災保険
            <input type="checkbox" name="xxx" value="健康保険"> 健康保険
            <input type="checkbox" name="xxx" value="厚生年金"> 厚生年金
        </div>
        <div class="job_form">
            育児休業の取得実績
<input type="radio" name="xxx" value="有"> 有
<input type="radio" name="xxx" value="無"> 無
        </div>
        <div class="job_form">
            勤務時間
            <textarea type="text" name="contact_text" placeholder="勤務時間をご入力ください"></textarea>
        </div>
        <div class="job_form">
            休憩時間
            <textarea type="text" name="contact_text" placeholder="休憩時間をご入力ください"></textarea>
        </div>
        <div class="job_form">
            休日
            <?php foreach ($job_holiday as $holiday_key) :
                echo '<input class="checkbox" type="checkbox" name="xxx" value="' . $holiday_key . '">' . $holiday_key .  '</option>';
            endforeach; ?>
        </div>
        <div class="job_form">
            休日備考
            <textarea type="text" name="contact_text" placeholder="休日備考をご入力ください"></textarea>
        </div>
        <div class="job_form">
            定年制度
<input type="radio" name="xxx" value="有"> 有
<input type="radio" name="xxx" value="無"> 無
        </div>
        <div class="job_form">
            定年年齢
            <input type="number" name="email" placeholder="定年年齢をご入力ください">
        </div>
        <div class="job_form">
            再雇用制度
<input type="radio" name="xxx" value="有"> 有
<input type="radio" name="xxx" value="無"> 無
        </div>
        <div class="job_form">
            試用期間有無
<input type="radio" name="xxx" value="有"> 有
<input type="radio" name="xxx" value="無"> 無
        </div>
        <div class="job_form">
            試用期間中の労働条件相違
            <input type="radio" name="xxx" value="有"> 有
            <input type="radio" name="xxx" value="無"> 無
        </div>
        <div class="job_form">
            お問い合わせ内容
            <textarea type="text" name="contact_text" placeholder="試用期間中の条件をご入力ください"></textarea>
        </div>
        <div class="job_form">
            応募先連絡先 電話番号
            <input type="text" name="email" placeholder="応募時の電話番号をご入力ください">
        </div>
        <div class="job_form">
            応募連絡先 メールアドレス
            <input type="text" name="email" placeholder="メールアドレスをご入力ください">
        </div>
        <div class="job_form">
            応募連絡先 その他
            <input type="text" name="email" placeholder="電話・メール以外の連絡先をご入力ください">
        </div>
        <div class="job_form">
            応募連絡先 採用担当者名
            <input type="text" name="email" placeholder="ご担当者名をご入力ください">
        </div>
        <div class="job_form">
            採用担当者名(ふりがな)
            <input type="text" name="email" placeholder="ふりがなをご入力ください">
        </div>
        <div class="job_form">
            ログインID
            <input type="text" name="email" placeholder="ログインID">
        </div>
        <div class="job_form">
            パスワード
            <input type="text" name="email" placeholder="パスワードをご入力ください">
        </div>
    </div>
    <div class="detail">
        <input class="submit_button" type="submit" value="上記の内容で求人掲載する">
    </div>


    <!-- フッター読み込み -->
    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
