<?php
$job_address_prefectures = ['都道府県を選んでください', '青森県', '秋田県', '岩手県', '山形県', '宮城県'];
$job_employment = ['雇用形態を選んでください', '正社員', '契約社員', 'パート・アルバイト', 'その他'];
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
        <select name="item" id="type">
            <?php foreach ($job_address_prefectures as $prefectures_key) :
                echo '<option value="' . $job_prefectures_key . '">' . $prefectures_key . '</option>';
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
                    echo '<option value="' . $job_prefectures_key . '">' . $prefectures_key . '</option>';
                endforeach; ?>
            </select>
        </div>
        <div class="job_form">
            勤務地 市区町村番地
            <input type="text" name="tel" placeholder="市区町村番地 建物名をご入力ください">
        </div>
        <div class="job_form">
            雇用形態
            <input type="text" name="email" placeholder="ラジオボタン">
        </div>
        <div class="job_form">
            最寄り駅
            <input type="text" name="email" placeholder="最寄り駅をご入力ください">
        </div>
        <div class="job_form">
            受動喫煙対策
            <input type="text" name="email" placeholder="ラジオボタン">
        </div>
        <div class="job_form">
            マイカー通勤
            <input type="text" name="email" placeholder="ラジオボタン">
        </div>
        <div class="job_form">
            転勤の可能性
            <input type="text" name="email" placeholder="ラジオボタン">
        </div>
        <div class="job_form">
            学歴
            <input type="text" name="email" placeholder="ラジオボタン">
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
            <input type="text" name="email" placeholder="ラジオボタン">
        </div>
        <div class="job_form">
            上限有無
            <input type="text" name="email" placeholder="ラジオボタン">
        </div>
        <div class="job_form">
            上限
            <input type="text" name="email" placeholder="上限額をご入力ください">
        </div>
        <div class="job_form">
            加入保険
            <input type="text" name="email" placeholder="チェックボックス">
        </div>
        <div class="job_form">
            育児休業の取得実績
            <input type="text" name="email" placeholder="ラジオボタン">
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
            <input type="text" name="email" placeholder="チェックボックス">
        </div>
        <div class="job_form">
            休日備考
            <textarea type="text" name="contact_text" placeholder="休日備考をご入力ください"></textarea>
        </div>
        <div class="job_form">
            定年
            <input type="text" name="email" placeholder="ラジオボタン">
        </div>
        <div class="job_form">
            定年年齢
            <input type="text" name="email" placeholder="定年年齢をご入力ください">
        </div>
        <div class="job_form">
            再雇用制度
            <input type="text" name="email" placeholder="ラジオボタン">
        </div>
        <div class="job_form">
            試用期間有無
            <input type="text" name="email" placeholder="ラジオボタン">
        </div>
        <div class="job_form">
            試用期間中の労働条件相違
            <input type="text" name="email" placeholder="ラジオボタン">
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
        <input type="submit" value="上記の内容で求人掲載する">
    </div>


    <!-- フッター読み込み -->
    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
