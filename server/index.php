<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';

// データベースに接続
$dbh = connect_db();

$job_address_prefectures = ['都道府県を選んでください', '青森県', '秋田県', '岩手県', '山形県', '宮城県'];
$job_employment = ['雇用形態を選んでください', '正社員', '契約社員', 'パート・アルバイト', 'その他'];
?>

<!DOCTYPE html>
<html lang="ja">
<!-- <head>の読み込み -->
<?php include_once __DIR__ . '/_head.php' ?>
<?php include_once __DIR__ . '/_header.php' ?>

<body>
    <form action="" method="post">
        <div class="top_forms">
            <div class="top_form">
                <p class="form_title">雇用形態</p>
                <select name="item" id="type">
                    <?php foreach ($job_employment as $employment_key) :
                        echo '<option value="' . $employment_key . '">' . $employment_key . '</option>';
                    endforeach; ?>
                </select>
            </div>
            <div class="top_form">
                <p class="form_title">職種</p>
                <input type="search" name="keyword" placeholder="職種名をご入力ください">
            </div>
            <div class="top_form">
                <p class="form_title">都道府県</p>
                <select name="item" id="type">
                    <?php foreach ($job_address_prefectures as $prefectures_key) :
                        echo '<option value="' . $prefectures_key . '">' . $prefectures_key . '</option>';
                    endforeach; ?>
                </select>
            </div>
            <div class="top_form">
                <input class="search_button button" type="submit" value="検索">
            </div>
        </div>
    </form>

    <div class="sub_title">
        <h1>最新の求人</h1>

        <div class="jobs job1">
            <div class="jobs_title jobs_left">
                <h2>企業名:◯◯</h2>
                <img src="sample.png" alt="aaa">
            </div>
            <div class="jobs_title jobs_right">
                <p>勤務地:岩手県西磐井郡</p>
                <p>雇用形態:正社員</p>
                <p>月給:20万円～30万円</p>
                <p>勤務時間:9:00～18:00</p>
                <p>休日:土日祝</p>
                <p>仕事内容:データの打ち込み、電話受付、営業のサポート</p>
            </div>
            <div class="detail">
                <a class="detail_button" href="" alt="">詳細を見る</a>
            </div>
        </div>
        <div class="jobs job1">
            <div class="jobs_title jobs_left">
                <h2>企業名:◯◯</h2>
                <img src="sample.png" alt="aaa">
            </div>
            <div class="jobs_title jobs_right">
                <p>勤務地:{$}</p>
                <p>雇用形態:{$}</p>
                <p>月給:{$}</p>
                <p>勤務時間:{$}</p>
                <p>休日:{$}</p>
                <p>仕事内容:{$}</p>
            </div>
            <div class="detail">
                <a class="detail_button" href="" alt="">詳細を見る</a>
            </div>
        </div>
        <div class="jobs job1">
            <div class="jobs_title jobs_left">
                <h2>企業名:◯◯</h2>
                <img src="sample.png" alt="aaa">
            </div>
            <div class="jobs_title jobs_right">
                <p>勤務地:{$}</p>
                <p>雇用形態:{$}</p>
                <p>月給:{$}</p>
                <p>勤務時間:{$}</p>
                <p>休日:{$}</p>
                <p>仕事内容:{$}</p>
            </div>
            <div class="detail">
                <a class="detail_button" href="" alt="">詳細を見る</a>
            </div>
        </div>
        <div class="detail">
            <a class="detail_button" href="" alt="">他の求人を見る</a>
        </div>
        <div class="detail">
            <a class="detail_button" href="" alt="">求人を掲載する</a>
        </div>

        <?php include_once __DIR__ . '/_footer.php' ?>
        
</body>

</html>
