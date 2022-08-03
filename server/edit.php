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
$status = 1;
$type =
$address_prefectures =
$address_detail =
$employment =
$station =
$smoke =
$commute =
$transfer =
$academic =
$experience =
$qualification =
$salary =
$allowance =
$allowance_limit =
$insurances =
$childcare_leave =
$work_hours =
$break_time =
$holiday =
$holiday_detail =
$retirement =
$retirement_remarks =
$rehire =
$trial_period =
$trial_period_span =
$trial_period_conditions =
$trial_period_conditions_detail =
$description =

$e_tel =
$e_tel_time =
$e_email =
$e_name =
$e_others = '';

$current_user = '';
$job_id = 0;
$job = '';

// セッションにidが保持されていなければ一覧画面にリダイレクト
// パラメータを受け取れなければ一覧画面にリダイレクト
if (empty($_SESSION['current_user']) || 
    empty($_GET['job_id'])) {
    header('Location: index.php');
    exit;
}
$current_user = $_SESSION['current_user'];

$job_id = filter_input(INPUT_GET, 'job_id');
$job = find_job($job_id);

$errors = [];

// 配列の用意
$sel_address_prefectures = ['都道府県を選択してください', '青森県', '秋田県', '岩手県', '山形県', '宮城県', '福島県'];
$sel_employment = ['雇用形態を選択してください', '正社員', '契約社員', 'パートアルバイト', 'その他'];
$sel_academic = ['必要学歴を選択してください','大学院卒','大学卒','高校卒','中学卒','不問'];
$sel_insurances = ['労災保険', '労働保険', '健康保険', '厚生年金'];
$sel_commute = ['可(駐車場有)', '可(駐車場無)', 'バイク可', '不可'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = filter_input(INPUT_POST, 'type');
    $address_prefectures = filter_input(INPUT_POST, 'address_prefectures');
    $address_detail = filter_input(INPUT_POST, 'address_detail');
    $employment = filter_input(INPUT_POST, 'employment');
    $station = filter_input(INPUT_POST, 'station');
    $smoke = filter_input(INPUT_POST, 'smoke');
    $commute = filter_input(INPUT_POST, 'commute');
    $transfer = filter_input(INPUT_POST, 'transfer');
    $academic = filter_input(INPUT_POST, 'academic');
    $experience = filter_input(INPUT_POST, 'experience');
    $qualification = filter_input(INPUT_POST, 'qualification');
    $salary = filter_input(INPUT_POST, 'salary');
    $allowance = filter_input(INPUT_POST, 'allowance');
    $allowance_limit = filter_input(INPUT_POST, 'allowance_limit');
    $insurances = filter_input(INPUT_POST, 'insurances');
    $childcare_leave = filter_input(INPUT_POST, 'childcare_leave');
    $work_hours = filter_input(INPUT_POST, 'work_hours');
    $break_time = filter_input(INPUT_POST, 'break_time');
    $holiday = filter_input(INPUT_POST, 'holiday');
    $holiday_detail = filter_input(INPUT_POST, 'holiday_detail');
    $retirement = filter_input(INPUT_POST, 'retirement');
    $retirement_remarks = filter_input(INPUT_POST, 'retirement_remarks');
    $rehire = filter_input(INPUT_POST, 'rehire');
    $trial_period = filter_input(INPUT_POST, 'trial_period');
    $trial_period_span = filter_input(INPUT_POST, 'trial_period_span');
    $trial_period_conditions = filter_input(INPUT_POST, 'trial_period_conditions');
    $trial_period_conditions_detail = filter_input(INPUT_POST, 'trial_period_conditions_detail');
    $description = filter_input(INPUT_POST, 'description');

    $e_tel = filter_input(INPUT_POST, 'e_tel');
    $e_tel_time = filter_input(INPUT_POST, 'e_tel_time');
    $e_email = filter_input(INPUT_POST, 'e_email');
    $e_name = filter_input(INPUT_POST, 'e_name');
    $e_others = filter_input(INPUT_POST, 'e_others');

    $errors = job_signup_validate(
        $type,$address_prefectures,$address_detail,$employment,$smoke,$commute,$transfer,$academic, $salary,
        $allowance, $insurances,$childcare_leave,$work_hours,$break_time,$holiday,$holiday_detail,
        $retirement,$retirement_remarks,$rehire,$trial_period,$trial_period_span,
        $trial_period_conditions,$trial_period_conditions_detail,$description,
        $e_tel,$e_tel_time,$e_email,$e_name);

    // エラーがなければ登録→管理画面へ遷移
    if (empty($errors)) {
        insert_job($current_user['id'],$status,$type,$address_prefectures,$address_detail,$employment,$station,$smoke,$commute,$transfer,
        $academic,$experience,$qualification,$salary,$allowance,$allowance_limit,$insurances,
        $childcare_leave,$work_hours,$break_time,$holiday,$holiday_detail,
        $retirement,$retirement_remarks,$rehire,$trial_period,$trial_period_span,
        $trial_period_conditions,$trial_period_conditions_detail,$description,
        $e_tel,$e_tel_time,$e_email,$e_name,$e_others);
        header('Location: management.php');
        exit;
    }
}
var_dump($job['commute']);
var_dump($job['retirement']);
?>

<!DOCTYPE html>
<html lang="ja">
<!-- ヘッダー読み込み -->
<?php include_once __DIR__ . '/_head.php' ?>

<body>
    <?php include_once __DIR__ . '/_header.php' ?>
    <section class="job_signup_content wrapper">
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
        <!-- ここから求人掲載フォーム -->
        <form class="signup_form" action="" method="post">
            <label class="type_label signup_label" for="type">募集する職種<span class="asterisk">*</span></label>
            <input type="text" name="type" id="type" placeholder="職種名(1つまで)" value="<?= h($job['type']) ?>">

            <label class="address_prefectures_label signup_label" for="address_prefectures">勤務地 都道府県<span class="asterisk">*</span></label>
            <select name="address_prefectures" id="address_prefectures">
                <?php foreach ($sel_address_prefectures as $address_prefectures_value) : ?>
                    <?php if ($address_prefectures_value === $job['address_prefectures']) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<option value='$address_prefectures_value' selected>" . $address_prefectures_value . "</option>"; ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<option value='$address_prefectures_value'>" . $address_prefectures_value . "</option>"; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>

            <label class="address_detail_label signup_label" for="address_detail">勤務地 市区町村番地 建物名<span class="asterisk">*</span></label>
            <input type="text" name="address_detail" id="address_detail" placeholder="建物名まで" value="<?= h($job['address_detail']) ?>">

            <label class="employment_label signup_label" for="employment">雇用形態<span class="asterisk">*</span></label>
            <select name="employment" id="employment">
                <?php foreach ($sel_employment as $employment_value) : ?>
                    <?php if ($employment_value === $job['employment']) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<option value='$employment_value' selected>" . $employment_value . "</option>"; ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<option value='$employment_value'>" . $employment_value . "</option>"; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>

            <label class="station_label  signup_label" for="station">最寄り駅</label>
            <input type="text" name="station" id="station" placeholder="最寄り駅" value="<?= h($job['station']) ?>">

            <label class="smoke_label  signup_label" for="smoke">受動喫煙防止対策<span class="asterisk">*</span></label>
            <input type="radio" name="smoke" value="敷地内全面禁煙"> 敷地内全面禁煙
            <input type="radio" name="smoke" value="分煙有り"> 分煙有り

            <label class="commuten_label  signup_label" for="commute">マイカー通勤<span class="asterisk">*</span></label>
            <?= "<input type='radio' name='commute' value='$job[commute]'>" . "可(駐車場有)"   ?>
            <?= "<input type='radio' name='commute' value='$job[commute]'>" . "可(駐車場無)"   ?>

            <!-- <input type="radio" name="commute" value="$job['commute']"> 可(駐車場有)
            <input type="radio" name="commute" value="$job['commute']"> 可(駐車場無)
            <input type="radio" name="commute" value="$job['commute']"> バイク可
            <input type="radio" name="commute" value="$job['commute']"> 不可 -->

            <!--foreachで作りたいがうまくいかない
            <?php foreach ($sel_commute as $commute_value) : ?>
                <?php if ($commute_value === $sel_commute) : ?>
                    ① POST データが存在する場合はこちらの分岐に入る
                    <?= "<input type='radio' value='$commute_value' checked>" . $commute_value ?>
                <?php else : ?>
                    ② POST データが存在しない場合はこちらの分岐に入る
                    <?= "<input type='radio' value='$commute_value'>" . $commute_value ?>
                <?php endif; ?>
            <?php endforeach; ?> -->

            <label class="transfer_label signup_label" for="transfer">転勤の可能性<span class="asterisk">*</span></label>
            <input type="radio" name="transfer" value="有"> 有
            <input type="radio" name="transfer" value="無"> 無

            <label class="academic_label signup_label" for="academic">必要学歴<span class="asterisk">*</span></label>
            <select name="academic" id="academic">
                <?php foreach ($sel_academic as $academic_value) : ?>
                    <?php if ($academic_value === $academic) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<option value='$academic_value' selected>" . $academic_value . "</option>"; ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<option value='$academic_value'>" . $academic_value . "</option>"; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>

            <label class="experience_label signup_label" for="experience">必要な経験</label>
            <input type="text" name="experience" id="experience" placeholder="必要な経験" value="<?= h($job['experience']) ?>">

            <label class="qualification_label signup_label" for="qualification">必要な資格・免許</label>
            <input type="text" name="qualification" id="qualification" placeholder="必要な資格・免許" value="<?= h($job['qualification']) ?>">

            <label class="salary_label signup_label" for="salary">給与<span class="asterisk">*</span></label>
            <textarea class="salary" name="salary" rows="5" maxlength="1000" placeholder="給与についてできるだけ詳細にご入力ください"><?= h($job['salary']) ?></textarea>

            <label class="allowance_label signup_label" for="allowance">通勤手当有無<span class="asterisk">*</span></label>
            <input type="radio" name="allowance" value="有"> 有
            <input type="radio" name="allowance" value="無"> 無

            <label class="allowance_limit signup_label" for="allowance_limit">通勤手当上限<span class="asterisk">*</span></label>
            <input type="text" name="allowance_limit" id="allowance_limit" placeholder="例:「実費全額支給」「月2万円まで実費支給」" value="<?= h($job['allowance_limit']) ?>">

            <label class="insurances_label signup_label" for="insurances">社会保険<span class="asterisk">*</span></label>
            <input type="checkbox" name="insurances" value="労災保険"> 労災保険
            <input type="checkbox" name="insurances" value="労働保険"> 労働保険
            <input type="checkbox" name="insurances" value="健康保険"> 健康保険
            <input type="checkbox" name="insurances" value="厚生年金"> 厚生年金
            <!-- 値が飛ばない・値が残らない -->
            <!-- <?php foreach ($sel_insurances as $insurances_value) : ?>
                <?php if ($insurances_value === $sel_insurances) : ?>
                    ① POST データが存在する場合はこちらの分岐に入る
                    <?= "<input type='checkbox' name='insurances' value='$insurances_value' checked>" . $insurances_value ?>
                <?php else : ?>
                    ② POST データが存在しない場合はこちらの分岐に入る
                    <?= "<input type='checkbox' name='insurances' value='$insurances_value'>" . $insurances_value ?>
                <?php endif; ?>
            <?php endforeach; ?> -->

            <label class="childcare_leave_label  signup_label" for="childcare_leave">育休の取得実績<span class="asterisk">*</span></label>
            <input type="radio" name="childcare_leave" value="有"> 有
            <input type="radio" name="childcare_leave" value="無"> 無

            <label class="work_hours_label signup_label" for="work_hours">就業時間<span class="asterisk">*</span></label>
            <textarea class="work_hours" name="work_hours" rows="5" maxlength="1000" placeholder="就業時間についてできるだけ詳細にご入力ください"><?= h($job['work_hours']) ?></textarea>

            <label class="break_time_label signup_label" for="break_time">休憩時間<span class="asterisk">*</span></label>
            <input type="text" name="break_time" id="break_time" placeholder="休憩時間" value="<?= h($job['break_time']) ?>">

            <label class="holiday_label signup_label" for="holiday">休日<span class="asterisk">*</span></label>
            <input type="text" name="holiday" id="holiday" placeholder="休日" value="<?= h($job['holiday']) ?>">

            <label class="holiday_detail_label signup_label" for="holiday_detail">休日詳細</label>
            <textarea class="holiday_detail" name="holiday_detail" rows="5" maxlength="1000" placeholder="休日についてできるだけ詳細にご入力ください"><?= h($job['holiday_detail']) ?></textarea>

            <label class="retirement_label signup_label" for="retirement">定年制度<span class="asterisk">*</span></label>
            <input type="radio" name="retirement" value="有"> 有
            <input type="radio" name="retirement" value="無"> 無

            <label class="retirement_remarks_label signup_label" for="retirement_remarks">定年年齢(60歳以上)</label>
            <input type="number" name="retirement_remarks" id="retirement_remarks" placeholder="定年年齢" min="60" max="80" value="<?= h($job['retirement_remarks']) ?>">

            <label class="rehire_label signup_label" for="rehire">再雇用制度<span class="asterisk">*</span></label>
            <input type="radio" name="rehire" value="有"> 有
            <input type="radio" name="rehire" value="無"> 無

            <label class="trial_period_label signup_label" for="trial_period">試用期間有無<span class="asterisk">*</span></label>
            <input type="radio" name="trial_period" value="有"> 有
            <input type="radio" name="trial_period" value="無"> 無

            <label class="trial_period_span_label signup_label" for="trial_period_span">試用期間<span class="asterisk">*</span></label>
            <textarea class="trial_period_span" name="trial_period_span" rows="5" maxlength="300" placeholder="試用期間についてご入力ください"><?= h($job['trial_period_span']) ?></textarea>

            <label class="trial_period_conditions_label signup_label" for="trial_period_conditions">試用期間中の労働条件相違<span class="asterisk">*</span></label>
            <input type="radio" name="trial_period_conditions" value="同じ"> 同じ
            <input type="radio" name="trial_period_conditions" value="異なる"> 異なる

            <label class="trial_period_conditions_detail_label signup_label" for="trial_period_conditions_detail">試用期間中の労働条件詳細<span class="asterisk">*</span></label>
            <textarea class="trial_period_conditions_detail" name="trial_period_conditions_detail" rows="5" maxlength="500" placeholder="試用期間中の労働条件についてできるだけ詳細にご入力ください"><?= h($job['trial_period_conditions_detail']) ?></textarea>

            <label class="description_label signup_label" for="description">仕事内容<span class="asterisk">*</span></label>
            <textarea class="description" name="description" rows="5" maxlength="1500" placeholder="仕事内容についてできるだけ詳細にご入力ください"><?= h($job['description']) ?></textarea>

            <label class="e_tel_label signup_label" for="e_tel">応募先電話番号<span class="asterisk">*</span></label>
            <input type="tel" name="e_tel" id="e_tel" placeholder="応募先電話番号" maxlength="13" value="<?= h($job['e_tel']) ?>">

            <label class="e_tel_time_label signup_label" for="e_tel_time">電話可能時間<span class="asterisk">*</span></label>
            <textarea class="e_tel_time" name="e_tel_time" rows="5" maxlength="500" placeholder="受電対応可能な時間帯をご入力ください"><?= h($job['e_tel_time']) ?></textarea>

            <label class="e_email_label signup_label" for="e_email">応募先メールアドレス<span class="asterisk">*</span></label>
            <input type="email" name="e_email" id="e_email" placeholder="応募先メールアドレス" value="<?= h($job['e_email']) ?>">

            <label class="e_name_label signup_label" for="e_name">応募先担当者名<span class="asterisk">*</span></label>
            <input type="text" name="e_name" id="e_name" placeholder="応募先担当者名" value="<?= h($job['e_name']) ?>">

            <label class="e_others_label signup_label" for="e_others">その他応募方法</label>
            <textarea class="e_others" name="e_others" rows="5" maxlength="500" placeholder="その他応募方法がある場合はこちらにご入力ください"><?= h($job['e_others']) ?></textarea>

            <div class="button_area">

                <input type="submit" value="求人情報を掲載する" class="signup_button">
            </div>
        </form>
    </section>
    <!-- フッター読み込み -->
    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
