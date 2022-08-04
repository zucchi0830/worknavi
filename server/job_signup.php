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
// $job = find_com_job($job_id);

// 変数の初期化
$status = 1;
$company_id =
$type =
$j_address_prefectures =
$j_address_detail =
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
$allowance_limit ='';
// $insurances = 
$insurance1 = 0;
$insurance2 = 0;
$insurance3 = 0;
$insurance4 = 0;
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

$job = '';

$errors = [];

// 配列の用意
$sel_address_prefectures = ['都道府県を選択してください', '青森県', '秋田県', '岩手県', '山形県', '宮城県', '福島県'];
$sel_employment = ['正社員', '契約社員', 'パートアルバイト', 'その他'];
$sel_academic = ['大学院卒','大学卒','高校卒','中学卒','不問'];
$sel_insurances = ['','労災保険', '労働保険', '健康保険', '厚生年金'];
$sel_commute = ['可(駐車場有)', '可(駐車場無)', 'バイク可', '不可'];
$sel_smoke =['敷地内全面禁煙','分煙室設置'];
$sel_ornot =['有','無'];

$e_name = $current_user['full_name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = filter_input(INPUT_POST, 'type');
    $j_address_prefectures = filter_input(INPUT_POST, 'j_address_prefectures');
    $j_address_detail = filter_input(INPUT_POST, 'j_address_detail');
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
    // $insurances = filter_input(INPUT_POST, 'insurances');
    $insurance1 = filter_input(INPUT_POST, 'insurance1'); //労災保険
    $insurance2 = filter_input(INPUT_POST, 'insurance2'); //労働保険
    $insurance3 = filter_input(INPUT_POST, 'insurance3'); //健康保険
    $insurance4 = filter_input(INPUT_POST, 'insurance4'); //厚生年金
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
    $type,$j_address_prefectures,$j_address_detail,$employment,$smoke,$commute,$transfer,$academic, $salary,
    $allowance, $allowance_limit, $insurance1, $insurance2, $insurance3, $insurance4, $childcare_leave,$work_hours,$break_time,$holiday,$holiday_detail,
    $retirement,$retirement_remarks,$rehire,$trial_period,$trial_period_span,
    $trial_period_conditions,$trial_period_conditions_detail,$description,
    $e_tel,$e_tel_time,$e_email,$e_name);

// エラーがなければ登録→管理画面へ遷移
if (empty($errors)) {
    insert_job($current_user['id'],$status,$type,$j_address_prefectures,$j_address_detail,$employment,$station,$smoke,$commute,$transfer,
    $academic,$experience,$qualification,$salary,$allowance,$allowance_limit, $insurance1, $insurance2, $insurance3, $insurance4, 
    $childcare_leave,$work_hours,$break_time,$holiday,$holiday_detail,
    $retirement,$retirement_remarks,$rehire,$trial_period,$trial_period_span,
    $trial_period_conditions,$trial_period_conditions_detail,$description,
    $e_tel,$e_tel_time,$e_email,$e_name,$e_others);
    header('Location: management.php');
    exit;
    }
}
// var_dump($current_user['email']);
// var_dump($current_user['id']);
// var_dump($current_user['name']);
// var_dump($current_user['full_name']);
var_dump($current_user);
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
            <input type="text" name="type" id="type" placeholder="職種名(1つまで)" value="<?= h($type) ?>">

            <label class="j_address_prefectures_label signup_label" for="j_address_prefectures">勤務地 都道府県<span class="asterisk">*</span></label>
            <select name="j_address_prefectures" id="j_address_prefectures">
                <?php foreach ($sel_address_prefectures as $j_address_prefectures_value) : ?>
                    <?php if ($j_address_prefectures_value === $j_address_prefectures) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<option value='$j_address_prefectures_value' selected>" . $j_address_prefectures_value . "</option>"; ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<option value='$j_address_prefectures_value'>" . $j_address_prefectures_value . "</option>"; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>

            <label class="j_address_detail_label signup_label" for="j_address_detail">勤務地 市区町村番地 建物名<span class="asterisk">*</span></label>
            <input type="text" name="j_address_detail" id="j_address_detail" placeholder="建物名まで" value="<?= h($j_address_detail) ?>">

            <label class="employment_label signup_label" for="employment">雇用形態<span class="asterisk">*</span></label>
                <?php foreach ($sel_employment as $employment_value) : ?>
                    <?php if ($employment_value === $employment) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='employment' value='$employment_value' id='$employment_value' checked>" . "<label for='$employment_value'>" . $employment_value . "</label>" ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='employment' value='$employment_value' id='$employment_value'>" . "<label for='$employment_value'>" . $employment_value . "</label>"?>
                    <?php endif; ?>
                <?php endforeach; ?>

            <label class="station_label  signup_label" for="station">最寄り駅</label>
            <input type="text" name="station" id="station" placeholder="最寄り駅" value="<?= h($station) ?>">

            <label class="smoke_label  signup_label" for="smoke">受動喫煙防止対策<span class="asterisk">*</span></label>
                <?php foreach ($sel_smoke as $smoke_value) : ?>
                    <?php if ($smoke_value === $smoke) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='smoke' value='$smoke_value' id='$smoke_value' checked>" . "<label for='$smoke_value'>" . $smoke_value . "</label>" ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='smoke' value='$smoke_value' id='$smoke_value'>" . "<label for='$smoke_value'>" . $smoke_value . "</label>"?>
                    <?php endif; ?>
                <?php endforeach; ?>

            <label class="commuten_label  signup_label" for="commute">マイカー通勤<span class="asterisk">*</span></label>
                <?php foreach ($sel_commute as $commute_value) : ?>
                    <?php if ($commute_value === $commute) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='commute' value='$commute_value' id='$commute_value' checked>" . "<label for='$commute_value'>" . $commute_value . "</label>" ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='commute' value='$commute_value' id='$commute_value'>" . "<label for='$commute_value'>" . $commute_value . "</label>"?>
                    <?php endif; ?>
                <?php endforeach; ?>

            <label class="transfer_label signup_label" for="transfer">転勤の可能性<span class="asterisk">*</span></label>
                <?php foreach ($sel_ornot as $transfer_value) : ?>
                    <?php if ($transfer_value === $transfer) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='transfer' value='$transfer_value' id='$transfer_value' checked>" . "<label for='$transfer_value'>" . $transfer_value . "</label>" ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='transfer' value='$transfer_value' id='$transfer_value'>" . "<label for='$transfer_value'>" . $transfer_value . "</label>"?>
                    <?php endif; ?>
                <?php endforeach; ?>

            <label class="academic_label signup_label" for="academic">必要学歴<span class="asterisk">*</span></label>
                <?php foreach ($sel_academic as $academic_value) : ?>
                    <?php if ($academic_value === $academic) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='academic' value='$academic_value' id='$academic_value' checked>" . "<label for='$academic_value'>" . $academic_value . "</label>" ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='academic' value='$academic_value' id='$academic_value'>" . "<label for='$academic_value'>" . $academic_value . "</label>"?>
                    <?php endif; ?>
                <?php endforeach; ?>

            <label class="experience_label signup_label" for="experience">必要な経験</label>
            <input type="text" name="experience" id="experience" placeholder="必要な経験" value="<?= h($experience) ?>">

            <label class="qualification_label signup_label" for="qualification">必要な資格・免許</label>
            <input type="text" name="qualification" id="qualification" placeholder="必要な資格・免許" value="<?= h($qualification) ?>">

            <label class="salary_label signup_label" for="salary">給与<span class="asterisk">*</span></label>
            <textarea class="salary" name="salary" rows="5" maxlength="1000" placeholder="給与についてできるだけ詳細にご入力ください"><?= h($salary) ?></textarea>

            <label class="allowance_label signup_label" for="allowance">通勤手当有無<span class="asterisk">*</span></label>
                <?php foreach ($sel_ornot as $allowance_value) : ?>
                    <?php if ($allowance_value === $allowance) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='allowance' value='$allowance_value' id='$allowance_value' checked>" . "<label for='$allowance_value'>" . $allowance_value . "</label>" ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='allowance' value='$allowance_value' id='$allowance_value'>" . "<label for='$allowance_value'>" . $allowance_value . "</label>"?>
                    <?php endif; ?>
                <?php endforeach; ?>

            <label class="allowance_limit signup_label" for="allowance_limit">通勤手当上限<span class="asterisk">*</span></label>
            <input type="text" name="allowance_limit" id="allowance_limit" placeholder="例:「実費全額支給」「月2万円まで実費支給」" value="<?= h($allowance_limit) ?>">

            <label class="insurances_label signup_label" for="insurances">社会保険<span class="asterisk">*</span></label>
            <?php if ( $insurance1 == $sel_insurances[1]) : ?>
                <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                <?= "<input type='checkbox' name='insurance1' value='$sel_insurances[1]' id='$sel_insurances[1]' checked>" . "<label for='$sel_insurances[1]'>" . "$sel_insurances[1]". "</label>" ?>
            <?php else : ?>
                <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                <?= "<input type='checkbox' name='insurance1' value='$sel_insurances[1]' id='$sel_insurances[1]'>" . "<label for='$sel_insurances[1]'>" . "$sel_insurances[1]". "</label>" ?>
            <?php endif; ?>
            <?php if ( $insurance2 == $sel_insurances[2]) : ?>
                <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                <?= "<input type='checkbox' name='insurance2' value='$sel_insurances[2]' id='$sel_insurances[2]' checked>" . "<label for='$sel_insurances[2]'>" . "$sel_insurances[2]". "</label>" ?>
            <?php else : ?>
                <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                <?= "<input type='checkbox' name='insurance2' value='$sel_insurances[2]' id='$sel_insurances[2]'>" . "<label for='$sel_insurances[2]'>" . "$sel_insurances[2]". "</label>" ?>
            <?php endif; ?>
            <?php if ( $insurance3 == $sel_insurances[3]) : ?>
                <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                <?= "<input type='checkbox' name='insurance3' value='$sel_insurances[3]' id='$sel_insurances[3]' checked>" . "<label for='$sel_insurances[3]'>" . "$sel_insurances[3]". "</label>" ?>
            <?php else : ?>
                <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                <?= "<input type='checkbox' name='insurance3' value='$sel_insurances[3]' id='$sel_insurances[3]'>" . "<label for='$sel_insurances[3]'>" . "$sel_insurances[3]". "</label>" ?>
            <?php endif; ?>
            <?php if ( $insurance4 == $sel_insurances[4]) : ?>
                <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                <?= "<input type='checkbox' name='insurance4' value='$sel_insurances[4]' id='$sel_insurances[4]' checked>" . "<label for='$sel_insurances[4]'>" . "$sel_insurances[4]". "</label>" ?>
            <?php else : ?>
                <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                <?= "<input type='checkbox' name='insurance4' value='$sel_insurances[4]' id='$sel_insurances[4]'>" . "<label for='$sel_insurances[4]'>" . "$sel_insurances[4]". "</label>" ?>
            <?php endif; ?>

            <label class="childcare_leave_label  signup_label" for="childcare_leave">育休の取得実績<span class="asterisk">*</span></label>
                <?php foreach ($sel_ornot as $childcare_leave_value) : ?>
                    <?php if ($childcare_leave_value === $childcare_leave) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='childcare_leave' value='$childcare_leave_value' id='$childcare_leave_value' checked>" . "<label for='$childcare_leave_value'>" . $childcare_leave_value . "</label>" ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='childcare_leave' value='$childcare_leave_value' id='$childcare_leave_value'>" . "<label for='$childcare_leave_value'>" . $childcare_leave_value . "</label>"?>
                    <?php endif; ?>
                <?php endforeach; ?>

            <label class="work_hours_label signup_label" for="work_hours">就業時間<span class="asterisk">*</span></label>
            <textarea class="work_hours" name="work_hours" rows="5" maxlength="1000" placeholder="就業時間についてできるだけ詳細にご入力ください"><?= h($work_hours) ?></textarea>

            <label class="break_time_label signup_label" for="break_time">休憩時間<span class="asterisk">*</span></label>
            <input type="text" name="break_time" id="break_time" placeholder="休憩時間" value="<?= h($break_time) ?>">

            <label class="holiday_label signup_label" for="holiday">休日<span class="asterisk">*</span></label>
            <input type="text" name="holiday" id="holiday" placeholder="休日" value="<?= h($holiday) ?>">

            <label class="holiday_detail_label signup_label" for="holiday_detail">休日詳細</label>
            <textarea class="holiday_detail" name="holiday_detail" rows="5" maxlength="1000" placeholder="休日についてできるだけ詳細にご入力ください"><?= h($holiday_detail) ?></textarea>

            <label class="retirement_label signup_label" for="retirement">定年制度<span class="asterisk">*</span></label>
                <?php foreach ($sel_ornot as $retirement_value) : ?>
                    <?php if ($retirement_value === $retirement) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='retirement' value='$retirement_value' id='$retirement_value' checked>" . "<label for='$retirement_value'>" . $retirement_value . "</label>" ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='retirement' value='$retirement_value' id='$retirement_value'>" . "<label for='$retirement_value'>" . $retirement_value . "</label>"?>
                    <?php endif; ?>
                <?php endforeach; ?>

            <label class="retirement_remarks_label signup_label" for="retirement_remarks">定年年齢(60歳以上)</label>
            <input type="number" name="retirement_remarks" id="retirement_remarks" placeholder="定年年齢" min="60" max="80" value="<?= h($retirement_remarks) ?>">

            <label class="rehire_label signup_label" for="rehire">再雇用制度<span class="asterisk">*</span></label>
                <?php foreach ($sel_ornot as $rehire_value) : ?>
                    <?php if ($rehire_value === $rehire) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='rehire' value='$rehire_value' id='$rehire_value' checked>" . "<label for='$rehire_value'>" . $rehire_value . "</label>" ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='rehire' value='$rehire_value' id='$rehire_value'>" . "<label for='$rehire_value'>" . $rehire_value . "</label>"?>
                    <?php endif; ?>
                <?php endforeach; ?>

            <label class="trial_period_label signup_label" for="trial_period">試用期間有無<span class="asterisk">*</span></label>
                <?php foreach ($sel_ornot as $trial_period_value) : ?>
                    <?php if ($trial_period_value === $trial_period) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='trial_period' value='$trial_period_value' id='$trial_period_value' checked>" . "<label for='$trial_period_value'>" . $trial_period_value . "</label>" ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='trial_period' value='$trial_period_value' id='$trial_period_value'>" . "<label for='$trial_period_value'>" . $trial_period_value . "</label>"?>
                    <?php endif; ?>
                <?php endforeach; ?>

            <label class="trial_period_span_label signup_label" for="trial_period_span">試用期間<span class="asterisk">*</span></label>
            <textarea class="trial_period_span" name="trial_period_span" rows="5" maxlength="300" placeholder="試用期間についてご入力ください"><?= h($trial_period_span) ?></textarea>

            <label class="trial_period_conditions_label signup_label" for="trial_period_conditions">試用期間中の労働条件相違<span class="asterisk">*</span></label>
                <?php foreach ($sel_ornot as $trial_period_conditions_value) : ?>
                    <?php if ($trial_period_conditions_value === $trial_period_conditions) : ?>
                        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='trial_period_conditions' value='$trial_period_conditions_value' id='$trial_period_conditions_value' checked>" . "<label for='$trial_period_conditions_value'>" . $trial_period_conditions_value . "</label>" ?>
                    <?php else : ?>
                        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
                        <?= "<input type='radio' name='trial_period_conditions' value='$trial_period_conditions_value' id='$trial_period_conditions_value'>" . "<label for='$trial_period_conditions_value'>" . $trial_period_conditions_value . "</label>"?>
                    <?php endif; ?>
                <?php endforeach; ?>

            <label class="trial_period_conditions_detail_label signup_label" for="trial_period_conditions_detail">試用期間中の労働条件詳細<span class="asterisk">*</span></label>
            <textarea class="trial_period_conditions_detail" name="trial_period_conditions_detail" rows="5" maxlength="500" placeholder="試用期間中の労働条件についてできるだけ詳細にご入力ください"><?= h($trial_period_conditions_detail) ?></textarea>

            <label class="description_label signup_label" for="description">仕事内容<span class="asterisk">*</span></label>
            <textarea class="description" name="description" rows="5" maxlength="1500" placeholder="仕事内容についてできるだけ詳細にご入力ください"><?= h($description) ?></textarea>

            <label class="e_tel_label signup_label" for="e_tel">応募先電話番号<span class="asterisk">*</span></label>
            <input type="tel" name="e_tel" id="e_tel" placeholder="応募先電話番号" maxlength="13" value="<?= h($e_tel) ?>">

            <label class="e_tel_time_label signup_label" for="e_tel_time">電話可能時間<span class="asterisk">*</span></label>
            <textarea class="e_tel_time" name="e_tel_time" rows="5" maxlength="500" placeholder="受電対応可能な時間帯をご入力ください"><?= h($e_tel_time) ?></textarea>

            <label class="e_email_label signup_label" for="e_email">応募先メールアドレス<span class="asterisk">*</span></label>
            <input type="email" name="e_email" id="e_email" placeholder="応募先メールアドレス" value="<?= h($e_email) ?>">

            <label class="e_name_label signup_label" for="e_name">応募先担当者名<span class="asterisk">*</span></label>
            <input type="text" name="e_name" id="e_name" placeholder="応募先担当者名" value="<?= h($e_name) ?>">

            <label class="e_others_label signup_label" for="e_others">その他応募方法</label>
            <textarea class="e_others" name="e_others" rows="5" maxlength="500" placeholder="その他応募方法がある場合はこちらにご入力ください"><?= h($e_others) ?></textarea>

            <div class="button_area">

                <input type="submit" value="求人情報を掲載する" class="signup_button">
            </div>
        </form>
    </section>
    <!-- フッター読み込み -->
    <?php include_once __DIR__ . '/_footer.php' ?>
</body>

</html>
