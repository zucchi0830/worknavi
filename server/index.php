<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';
// セッション開始
session_start();

// データベースに接続
$dbh = connect_db();

// 変数の初期化
$name = '';
$company_id = '';
$sel_address_prefectures = ['都道府県を選択してください', '青森県', '秋田県', '岩手県', '山形県', '宮城県', '福島県'];
$sel_employment = ['雇用形態を選択してください', '正社員', '契約社員', 'パートアルバイト', 'その他'];

$companys_jobs = find_com_job_all();
?>

<!-- jobs>company_idを持ってきて、それをもとに、companytableを検索する
その結果を持ってきて、会社情報を出す -->

<!DOCTYPE html>
<html lang="ja">
<!-- <head>の読み込み -->
<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>
    <section class="search_content wrapper">
        <h1 class="signup_title">求人検索はこちら</h1>

        <form class="signup_form" action="" method="post">
            <label class="address_prefectures_label signup_label" for="name">都道府県</label>
            <select name="address_prefectures" id="address_prefectures">
                <?php foreach ($sel_address_prefectures as $value) : ?>
                    <?php if ($value === $address_prefectures) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<option value='$value' selected>" . $value . "</option>"; ?>
                    <?php else : ?>
                        <!--  ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<option placeholder='a' value='$value'>" . $value . "</option>"; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>

            <label class="name_label signup_label" for="name">職種</label>
            <input type="text" name="name" id="name" placeholder="職種名を入力してください" value="<?= h($name) ?>">

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

            <input type="submit" value="検索する" class="search_button">
            </div>
        </form>
    </section>

    <div class="sub_title">
        <h1>最新の求人</h1>
        <div class="jobs job1">
        <?php foreach ($companys_jobs as $job) : ?>
                <div class="jobtitle">

                <h1 class="index_job_title">会社名:<?= $job['name'] ?></h1>                
                <ul>
                    <li></li>
                    <li>職種:<?=  $job['type'] ?></li>
                    <li>勤務地:<?=  $job['j_address_prefectures']?></li>
                    <li>雇用形態:<?=  $job['employment'] ?></li>
                    <li>給与:<?=  $job['salary'] ?></li>
                    <li>勤務時間:<?=  $job['work_hours'] ?></li>
                    <li>休日:<?=  $job['holiday'] ?></li>
                </ul>
            <div class="detail">
                <a class="detail_button" href="show.php?job_id=<?= h($job['id']) ?>">詳細を見る</a>
            </div>
        </div>
        <hr>
        <?php endforeach; ?>
    </div>    
        

<!-- ↓モックアップ用 -->
        <!-- <div class="jobs job1">
            <div class="jobs_title jobs_left">
                <h2>企業名:◯◯</h2>
                <img src="/images/sample.png" alt="aaa">
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
                <img src="/images/sample.png" alt="aaa">
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
                <img src="/images/sample.png" alt="aaa">
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
        </div> -->
        <div class="detail">
            <a class="detail_button" href="show_list.php" alt="">他の求人を見る</a>
        </div>
        <div class="detail">
            <a class="detail_button" href="signup.php" alt="">求人を掲載する</a>
        </div>
        <div class="detail">
            <a class="detail_button" href="signup.php" alt="">ここにアフィリエイト ここにアフィリエイト</a>
        </div>
        
    </div>
    <?php include_once __DIR__ . '/_footer.php' ?>

</body>

</html>
