<?php 
    // セッション開始
    session_start();
    ?>


<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_head.php' ?>


    <title>予約表</title>
    <style>
    table,tr,td,th{
        border: solid 1px black; border-collapse: collapse;
        padding: 5px 20px;

    }
    td,th{
        min-width: 32px;
    }
    th{
        background: #fff;
    }
    .management_table {
    margin: 0 auto;
    }
    </style>
    
</head>
<body>
<?php include_once __DIR__ . '/_header.php' ?>
    <section class="management_content wrapper">
        <h1 class="signup_title">管理画面</h1> 
        <table class="management_table">
            <tr>
                <th>募集職種</th><th>勤務地</th><th>仕事内容</th><th>掲載ステータス</th><th>編集</th>
            </tr>
            <tr>
                <th>事務員</th><th>八戸市◯◯</th><th>PCの打ち込み、営業受付</th><th><a href="">掲載中</a></th>
                <th>編集する<br>一時停止<br>削除</th>
            </tr>
            <tr>
                <th>事務員</th><th>八戸市◯◯</th><th>PCの打ち込み、営業受付</th><th><a href="">掲載中</a></th>
                <th>編集する<br>一時停止<br>削除</th>
            </tr>
            <tr>
                <th>事務員</th><th>八戸市◯◯</th><th>PCの打ち込み、営業受付</th><th><a href="">掲載中</a></th>
                <th>編集する<br>一時停止<br>削除</th>
            </tr>
        </table>
            <div class="button_area">
                <a href="job_signup.php" class="signup_button" class="nav-link">求人を掲載する</a>
                <a href="logout.php" class="login_page_button" class="nav-link">ログアウトする</a>
            </div>
    </section>
    <!-- フッター読み込み -->
    <?php include_once __DIR__ . '/_footer.php' ?>
</body>
</html>
