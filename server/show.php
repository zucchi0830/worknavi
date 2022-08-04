<?php
// 関数ファイルを読み込む
require_once __DIR__ . '/common/functions.php';
// セッション開始
session_start();

$current_user = '';

// パラメータが渡されていなければ一覧画面に戻す
$job_id = filter_input(INPUT_GET,'job_id');
if (empty($job_id)) {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user'];
}
// $job_id = filter_input(INPUT_GET, 'job_id');

// idを基にデータを取得
$job = find_com_job($job_id);
?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>

    <section class="management_content wrapper">
        <h1 class="signup_title"><?= h($job['name']) , "  " . h($job['type']) ?>の求人情報です</h1>
        <table class="management_table">
            <tr>
                <th>職種</th>
                <th><?= h($job['type']) ?></th>
            </tr>
            <tr>
                <th>勤務地 都道府県</th>
                <th><?= h($job['j_address_prefectures']) ?></th>
            </tr>
            <tr>
                <th>勤務地 市区町村</th>
                <th><?= h($job['j_address_detail']) ?></th>
            </tr>
            <tr>
                <th>雇用形態</th>
                <th><?= h($job['employment']) ?></th>
            </tr>
            <tr>
                <th>最寄り駅</th>
                <th><?= h($job['station']) ?></th>
            </tr>
            <tr>
                <th>受動喫煙防止対策</th>
                <th><?= h($job['smoke']) ?></th>
            </tr>
            <tr>
                <th>マイカー通勤</th>
                <th><?= h($job['commute']) ?></th>
            </tr>
            <tr>
                <th>転勤の可能性</th>
                <th><?= h($job['transfer']) ?></th>
            </tr>
            <tr>
                <th>必要な学歴</th>
                <th><?= h($job['academic']) ?></th>
            </tr>
            <tr>
                <th>必要な経験</th>
                <th><?= h($job['experience']) ?></th>
            </tr>
            <tr>
                <th>必要な資格</th>
                <th><?= h($job['qualification']) ?></th>
            </tr>
            <tr>
                <th>給与</th>
                <th><?= h($job['salary']) ?></th>
            </tr>
            <tr>
                <th>通勤手当有無</th>
                <th><?= h($job['allowance']) ?></th>
            </tr>
            <tr>
                <th>通勤手当上限</th>
                <th><?= h($job['allowance_limit']) ?></th>
            </tr>
            <tr>
                <th>社会保険</th>
                <th><?= h($job['insurance1'] . " " . $job['insurance2'] . " " . $job['insurance3'] . " " . $job['insurance4']) ?></th>
            </tr>
            <tr>
                <th>育休の取得実績有無</th>
                <th><?= h($job['childcare_leave']) ?></th>
            </tr>
            <tr>
                <th>就業時間</th>
                <th><?= h($job['work_hours']) ?></th>
            </tr>
            <tr>
                <th>休憩時間</th>
                <th><?= h($job['break_time']) ?></th>
            </tr>
            <tr>
                <th>休日</th>
                <th><?= h($job['holiday']) ?></th>
            </tr>
            <tr>
                <th>休日詳細</th>
                <th><?= h($job['holiday_detail']) ?></th>
            </tr>
            <tr>
                <th>定年制度</th>
                <th><?= h($job['retirement']) ?></th>
            </tr>
            <tr>
                <th>定年年齢</th>
                <th><?= h($job['retirement_remarks']) ?></th>
            </tr>
            <tr>
                <th>再雇用制度</th>
                <th><?= h($job['rehire']) ?></th>
            </tr>
            <tr>
                <th>試用期間有無</th>
                <th><?= h($job['trial_period']) ?></th>
            </tr>
            <tr>
                <th>試用期間</th>
                <th><?= h($job['trial_period_span']) ?></th>
            </tr>
            <tr>
                <th>試用期間中の労働条件相違</th>
                <th><?= h($job['trial_period_conditions']) ?></th>
            </tr>
            <tr>
                <th>試用期間中の労働条件詳細</th>
                <th><?= h($job['trial_period_conditions_detail']) ?></th>
            </tr>
            <tr>
                <th>仕事内容</th>
                <th><?= h($job['description']) ?></th>
            </tr>
        </table>

        <h1 class="signup_title">応募はこちらから</h1>
        <table class="management_table">
            <tr>
                <th>応募先電話番号</th>
                <th><?= h($job['e_tel']) ?></th>
            </tr>
            <tr>
                <th>電話可能時間</th>
                <th><?= h($job['e_tel_time']) ?></th>
            </tr>
            <tr>
                <th>応募先メールアドレス</th>
                <th><?= h($job['e_email']) ?></th>
            </tr>
            <tr>
                <th>採用担当者名</th>
                <th><?= h($job['e_name']) ?></th>
            </tr>
            <tr>
                <th>応募方法</th>
                <th><?= '電話にて、「東北ワークナビを見た」とお伝え下さい。' ?></th>
            </tr>
            <tr>
                <th>応募情報補足</th>
                <th><?= h($job['e_others']) ?></th>
            </tr>
        </table>
        <div class="button_area">
            <a href="index.php" class="search_button" class="nav-link">ここにアフィリエイト ここにアフィリエイト</a>
        </div>

        <h1 class="signup_title">応募先の会社情報</h1>
        <table class="management_table">
            <tr>
                <th>会社名</th><th><?= h($job['name']) ?></th>
            </tr>
            <tr>
                <th>本社住所</th><th><?= h($job['address_prefectures'] . $job['address_detail']) ?></th>
            </tr>
            <tr>
                <th>HP URL</th><th><?= h($job['homepage']) ?></th>
            </tr>
        </table>
            <div class="button_area">
                <a href="index.php" class="search_button" class="nav-link">他の求人を見る</a>
            </div>

            <div class="content">
            <?php if (!empty($current_user) && $current_user['id'] == $job['company_id']) : ?>
                <h1>管理者情報</h1>
                <div class="button">
                    <a href="edit.php" class="edit_button">
                        <a href="edit.php?job_id=<?= h($job['id']) ?>" class="edit_button">編集</a>
                        <button class="delete_button" onclick="if (!confirm('本当に削除してよろしいですか？')) {return false}; 
                        location.href='delete.php?job_id=<?= h($job['id']) ?>'">削除</button>
                </div><br>
                掲載ステータス:
                <?php if ($job['status'] == true) : ?>掲載中<button class="status_stop_button" onclick="if (!confirm('掲載を停止してよろしいですか？')) {return false}; 
                                location.href='status_stop.php?job_id=<?= h($job['id']) ?>'"><u>(掲載停止する)</u>
                <?php elseif($job['status'] == false) : ?>掲載停止中 <button class="status_start_button" onclick="if (!confirm('求人を掲載してよろしいですか？')) {return false}; 
                location.href='status_start.php?job_id=<?= h($job['id']) ?>'"><u>(掲載開始する)</u>
                <?php endif; ?>                
            </div>
            <?php endif; ?>
        </div>
    </section>


    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
