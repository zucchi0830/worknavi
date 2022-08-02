<?php
$address_prefectures = [
    '', '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県',
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

?>
<!DOCTYPE html>
<html lang="ja">
<!-- ヘッダー読み込み -->
<?php include_once __DIR__ . '/_head.php' ?>
<?php include_once __DIR__ . '/_header.php' ?>

<body>
    <div class="contact_container">
        <h1 class="contact_sub_title">お問い合わせ</h1>
        <div class="top_form">
            <p>会社名</p>
            <input type="text" name="company" placeholder="職種名をご入力ください">
        </div>
        <div class="top_form">
            <p>氏名</p>
            <input type="text" name="name" placeholder="職種名をご入力ください">
        </div>
        <div class="top_form">
            <p>都道府県</p>
            <select name="item" id="type">
                <?php foreach ($address_prefectures as $prefectures_key) :
                    echo '<option value="' . $prefectures_key . '">' . $prefectures_key . '</option>';
                endforeach; ?>
            </select>
        </div>
        <div class="top_form">
            <p>市区町村</p>
            <input type="text" name="name" placeholder="職種名をご入力ください">
        </div>
        <div class="top_form">
            <p>電話番号</p>
            <input type="text" name="tel" placeholder="職種名をご入力ください">
        </div>
        <div class="top_form">
            <p>メールアドレス</p>
            <input type="text" name="email" placeholder="職種名をご入力ください">
        </div>
        <div class="top_form">
            <p>お問い合わせ内容</p>
            <textarea type="text" name="contact_text" placeholder="職種名をご入力ください"></textarea>
        </div>
    </div>
    <div class="detail">
        <input class="submit_button" type="submit" value="上記の内容で問い合わせる">
    </div>


    <!-- フッター読み込み -->
    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
