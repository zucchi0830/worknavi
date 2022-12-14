<?php
require_once __DIR__ . '/config.php';

// 接続処理を行う関数
function connect_db()
{
    try {
        return new PDO(
            DSN,
            USER,
            PASSWORD,
            [PDO::ATTR_ERRMODE =>
            PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

// エスケープ処理を行う関数
function h($str)
{
    // ENT_QUOTES: シングルクオートとダブルクオートを共に変換する。
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


// 会社情報登録画面エラーメッセージ表示(バリデーション)
function signup_validate($name, $address_prefectures, $address_detail, $full_name, $email, $password)
{
    $errors = [];

    if (empty($name)) {  //会社名
        $errors[] = MSG_NAME_REQUIRED;
    }

    if ($address_prefectures == '都道府県を選択してください') { //都道府県
        $errors[] = MSG_ADDRESS_PREFECTURES_REQUIRED;
    }

    if (empty($address_detail)) { //市区町村以降
        $errors[] = MSG_ADDRESS_DETAIL_REQUIRED;
    }

    if (empty($full_name)) { //担当者名
        $errors[] = MSG_E_NAME_REQUIRED;
    }

    if (empty($email)) { //メールアドレス
        $errors[] = MSG_EMAIL_REQUIRED;
    }

    if (empty($password)) { //パスワード
        $errors[] = MSG_PASSWORD_REQUIRED;
    }

    if (
        empty($errors) &&
        check_exist_user($email)
    ) { //メールアドレス重複チェック
        $errors[] = MSG_EMAIL_DUPLICATE;
    }
    return $errors;
}

// 会社情報新規登録
function insert_company($name, $address_prefectures, $address_detail, $homepage, $full_name, $email, $password)
{
    $dbh = connect_db();

    $sql = <<<EOM
    INSERT INTO
        companys
        (name, address_prefectures, address_detail, homepage, full_name, email, password)
    VALUES
        (:name, :address_prefectures, :address_detail, :homepage, :full_name, :email, :password)
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':address_prefectures', $address_prefectures, PDO::PARAM_STR);
    $stmt->bindValue(':address_detail', $address_detail, PDO::PARAM_STR);
    $stmt->bindValue(':homepage', $homepage, PDO::PARAM_STR);
    $stmt->bindValue(':full_name', $full_name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $pw_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindValue(':password', $pw_hash, PDO::PARAM_STR);

    $stmt->execute();
}

// メールアドレス重複チェック
function check_exist_user($email)
{
    $err = false;

    $dbh = connect_db();

    $sql = <<<EOM
    SELECT 
        * 
    FROM 
        companys
    WHERE 
        email = :email;
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($user)) {
        $err = true;
    }
    return $err;
}

// ログインエラー(バリデーション)
function login_validate($email, $password)
{
    $errors = [];

    if (empty($email)) {
        $errors[] = MSG_EMAIL_REQUIRED;
    }

    if (empty($password)) {
        $errors[] = MSG_PASSWORD_REQUIRED;
    }

    return $errors;
}

// ログイン機能
function find_user_by_email($email)
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT
        *
    FROM
        companys
    WHERE
        email = :email;
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// お問い合わせフォーム
function contact_validate(
    $name,
    $full_name,
    $address_prefectures,
    $address_detail,
    $homepage,
    $tel,
    $email,
    $description
) {
    $errors = [];

    if (empty($name)) {  //会社名
        $errors[] = MSG_NAME_REQUIRED;
    }

    if (empty($full_name)) { //氏名
        $errors[] = MSG_FULLNAME_REQUIRED;
    }

    if ($address_prefectures == '都道府県を選択してください') { //都道府県
        $errors[] = MSG_ADDRESS_PREFECTURES_REQUIRED;
    }

    if (empty($address_detail)) { //市区町村以降
        $errors[] = MSG_ADDRESS_DETAIL_REQUIRED;
    }

    if (empty($tel)) { //電話番号
        $errors[] = MSG_TEL_REQUIRED;
    }

    if (empty($email)) { //メールアドレス
        $errors[] = MSG_EMAIL_REQUIRED;
    }

    return $errors;
}

//お問い合わせ内容登録
function insert_contact(
    $name,
    $full_name,
    $address_prefectures,
    $address_detail,
    $homepage,
    $tel,
    $email,
    $description
) {
    $dbh = connect_db();

    $sql = <<<EOM
    INSERT INTO
        contacts
        (name, full_name, address_prefectures, address_detail, homepage, tel, email, description)
    VALUES
        (:name, :full_name, :address_prefectures, :address_detail, :homepage, :tel, :email, :description)
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':full_name', $full_name, PDO::PARAM_STR);
    $stmt->bindValue(':address_prefectures', $address_prefectures, PDO::PARAM_STR);
    $stmt->bindValue(':address_detail', $address_detail, PDO::PARAM_STR);
    $stmt->bindValue(':homepage', $homepage, PDO::PARAM_STR);
    $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);

    $stmt->execute();
}

//求人登録
function insert_job(
    $company_id,
    $status,
    $type,
    $j_address_prefectures,
    $j_address_detail,
    $employment,
    $station,
    $smoke,
    $commute,
    $transfer,
    $academic,
    $experience,
    $qualification,
    $salary,
    $allowance,
    $allowance_limit,
    $insurance1,
    $insurance2,
    $insurance3,
    $insurance4,
    $childcare_leave,
    $work_hours,
    $break_time,
    $holiday,
    $holiday_detail,
    $retirement,
    $retirement_remarks,
    $rehire,
    $trial_period,
    $trial_period_span,
    $trial_period_conditions,
    $trial_period_conditions_detail,
    $description,
    $e_tel,
    $e_tel_time,
    $e_email,
    $e_name,
    $e_others, $upload_file, $job_title
) 
{
$dbh = connect_db();

    $sql = <<<EOM
    INSERT INTO
        jobs
        (company_id, status, type, j_address_prefectures, j_address_detail, employment, station, smoke, commute, transfer,
        academic, experience, qualification, salary, allowance, allowance_limit, insurance1, insurance2, insurance3, insurance4,
        childcare_leave, work_hours, break_time, holiday, holiday_detail,
        retirement, retirement_remarks, rehire, trial_period, trial_period_span,
        trial_period_conditions, trial_period_conditions_detail, description,
        e_tel, e_tel_time, e_email, e_name, e_others,image1, job_title)
    VALUES
        (:company_id, :status, :type, :j_address_prefectures, :j_address_detail, :employment, :station, :smoke, :commute, :transfer,
        :academic, :experience, :qualification, :salary, :allowance, :allowance_limit, :insurance1, :insurance2, :insurance3, :insurance4,
        :childcare_leave, :work_hours, :break_time, :holiday, :holiday_detail,
        :retirement, :retirement_remarks, :rehire, :trial_period, :trial_period_span,
        :trial_period_conditions, :trial_period_conditions_detail, :description,
        :e_tel, :e_tel_time, :e_email, :e_name, :e_others,:image1, :job_title)
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':company_id', $company_id, PDO::PARAM_STR);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':type', $type, PDO::PARAM_STR);
    $stmt->bindValue(':j_address_prefectures', $j_address_prefectures, PDO::PARAM_STR);
    $stmt->bindValue(':j_address_detail', $j_address_detail, PDO::PARAM_STR);
    $stmt->bindValue(':employment', $employment, PDO::PARAM_STR);
    $stmt->bindValue(':station', $station, PDO::PARAM_STR);
    $stmt->bindValue(':smoke', $smoke, PDO::PARAM_STR);
    $stmt->bindValue(':commute', $commute, PDO::PARAM_STR);
    $stmt->bindValue(':transfer', $transfer, PDO::PARAM_STR);
    $stmt->bindValue(':academic', $academic, PDO::PARAM_STR);
    $stmt->bindValue(':experience', $experience, PDO::PARAM_STR);
    $stmt->bindValue(':qualification', $qualification, PDO::PARAM_STR);
    $stmt->bindValue(':salary', $salary, PDO::PARAM_STR);
    $stmt->bindValue(':allowance', $allowance, PDO::PARAM_STR);
    $stmt->bindValue(':allowance_limit', $allowance_limit, PDO::PARAM_STR);
    $stmt->bindValue(':insurance1', $insurance1, PDO::PARAM_STR);
    $stmt->bindValue(':insurance2', $insurance2, PDO::PARAM_STR);
    $stmt->bindValue(':insurance3', $insurance3, PDO::PARAM_STR);
    $stmt->bindValue(':insurance4', $insurance4, PDO::PARAM_STR);
    $stmt->bindValue(':childcare_leave', $childcare_leave, PDO::PARAM_STR);
    $stmt->bindValue(':work_hours', $work_hours, PDO::PARAM_STR);
    $stmt->bindValue(':break_time', $break_time, PDO::PARAM_STR);
    $stmt->bindValue(':holiday', $holiday, PDO::PARAM_STR);
    $stmt->bindValue(':holiday_detail', $holiday_detail, PDO::PARAM_STR);
    $stmt->bindValue(':retirement', $retirement, PDO::PARAM_STR);
    $stmt->bindValue(':retirement_remarks', $retirement_remarks, PDO::PARAM_STR);
    $stmt->bindValue(':rehire', $rehire, PDO::PARAM_STR);
    $stmt->bindValue(':trial_period', $trial_period, PDO::PARAM_STR);
    $stmt->bindValue(':trial_period_span', $trial_period_span, PDO::PARAM_STR);
    $stmt->bindValue(':trial_period_conditions', $trial_period_conditions, PDO::PARAM_STR);
    $stmt->bindValue(':trial_period_conditions_detail', $trial_period_conditions_detail, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':e_tel', $e_tel, PDO::PARAM_STR);
    $stmt->bindValue(':e_tel_time', $e_tel_time, PDO::PARAM_STR);
    $stmt->bindValue(':e_email', $e_email, PDO::PARAM_STR);
    $stmt->bindValue(':e_name', $e_name, PDO::PARAM_STR);
    $stmt->bindValue(':e_others', $e_others, PDO::PARAM_STR);
    $stmt->bindValue(':image1', $upload_file, PDO::PARAM_STR);
    $stmt->bindValue(':job_title', $job_title, PDO::PARAM_STR);

    $stmt->execute();
}

// 求人掲載用のエラーメッセージ表示(バリデーション)
function job_signup_validate(
    $job_title,
    $type,
    $j_address_prefectures,
    $j_address_detail,
    $employment,
    $smoke,
    $commute,
    $transfer,
    $academic,
    $salary,
    $allowance,
    $allowance_limit,
    $insurance1,
    $insurance2,
    $insurance3,
    $insurance4,
    $childcare_leave,
    $work_hours,
    $break_time,
    $holiday,
    $holiday_detail,
    $retirement,
    $retirement_remarks,
    $rehire,
    $trial_period,
    $trial_period_span,
    $trial_period_conditions,
    $trial_period_conditions_detail,
    $description,
    $e_tel,
    $e_tel_time,
    $e_email,
    $e_name, $upload_file
) {
    $errors = [];

    if (empty($job_title)) { //求人タイトル
        $errors[] = MSG_NO_JOB_TITLE;
    }

    if (empty($type)) {  //職種
        $errors[] = MSG_TYPE_REQUIRED;
    }

    if ($j_address_prefectures == '都道府県を選択してください') { //都道府県
        $errors[] = MSG_ADDRESS_PREFECTURES_REQUIRED;
    }

    if (empty($j_address_detail)) { //市区町村以降
        $errors[] = MSG_ADDRESS_DETAIL_REQUIRED;
    }

    if (empty($employment)) { //雇用形態
        $errors[] = MSG_EMPLOYMENT_REQUIRED;
    }

    if (empty($smoke)) { //受動喫煙防止対策
        $errors[] = MSG_SMOKE_REQUIRED;
    }

    if (empty($commute)) { //マイカー通勤
        $errors[] = MSG_COMMUTE_REQUIRED;
    }

    if (empty($transfer)) { //転勤有無
        $errors[] = MSG_TRANSFER_REQUIRED;
    }

    if (empty($academic)) { //== '必要学歴を選択してください' //必要学歴
        $errors[] = MSG_ACADEMIC_REQUIRED;
    }

    if (empty($salary)) { //給与
        $errors[] = MSG_SALARY_REQUIRED;
    }

    if (empty($allowance)) { //通勤手当有無
        $errors[] = MSG_ALLOWANCE_REQUIRED;
    }

    if ($allowance == '有' && empty($allowance_limit)) { //通勤手当上限
        $errors[] = MSG_ALLOWANCE_LIMIT_REQUIRED;
    }

    // if (empty($insurances)) { //社会保険加入有無
    //     $errors[] = MSG_INSURANCES_REQUIRED;
    // }

    if (empty($childcare_leave)) { //育休の取得実績有無
        $errors[] = MSG_CHILDCARE_LEAVE_REQUIRED;
    }

    if (empty($work_hours)) { //就業時間
        $errors[] = MSG_WORK_HOURS_REQUIRED;
    }

    if (empty($break_time)) { //休憩時間
        $errors[] = MSG_BREAK_TIME_REQUIRED;
    }

    if (empty($holiday)) { //休日
        $errors[] = MSG_HOLIDAY_REQUIRED;
    }

    // if (empty($holiday_detail)) { //休日詳細
    //     $errors[] = MSG_HOLIDAY_DETAIL_REQUIRED;
    // }

    if (empty($retirement)) { //定年制度
        $errors[] = MSG_RETIREMENT_REQUIRED;
    }

    if ($retirement == '有' && empty($retirement_remarks)) { //定年年齢
        $errors[] = MSG_RETIREMENT_REMARKS_REQUIRED;
    }


    if (empty($rehire)) { //再雇用制度
        $errors[] = MSG_REHIRE_REQUIRED;
    }

    if (empty($trial_period)) { //試用期間有無
        $errors[] = MSG_TRIAL_PERIOD_REQUIRED;
    }

    if ($trial_period == '有' && empty($trial_period_span)) { //試用期間
        $errors[] = MSG_TRIAL_PERIOD_SPAN_REQUIRED;
    }

    if (empty($trial_period_conditions)) { //試用期間中の労働条件相違
        $errors[] = MSG_TRIAL_PERIOD_CONDITIONS_REQUIRED;
    }

    if ($trial_period_conditions == '有' && empty($trial_period_conditions_detail)) { //試用期間中の労働条件詳細
        $errors[] = MSG_TRIAL_PERIOD_CONDITIONS_DETAIL_REQUIRED;
    }

    if (empty($description)) { //仕事内容
        $errors[] = MSG_DESCRIPTION_REQUIRED;
    }

    if (empty($e_tel)) { //電話番号
        $errors[] = MSG_TEL_REQUIRED;
    }

    if (empty($e_tel_time)) { //電話可能時間帯
        $errors[] = MSG_E_TEL_TIME_REQUIRED;
    }

    if (empty($e_email)) { //メールアドレス
        $errors[] = MSG_EMAIL_REQUIRED;
    }
    if (empty($e_name)) { //採用担当者名
        $errors[] = MSG_E_NAME_REQUIRED;
    }

    // if (empty($upload_file)) { //画像添付
    //     $errors[] = MSG_NO_IMAGE;    
    //     } elseif (check_file_ext($upload_file)) {
    //     $errors[] = MSG_NOT_ABLE_EXT;
    // }

    if (!empty($upload_file) &&
    check_file_ext($upload_file)) {  //画像が変更されていた場合は、拡張子チェック
    $errors[] = MSG_NOT_ABLE_EXT;
    }
    return $errors;
}

//画像投稿バリデーション
// function job_update_image_validate($upload_file)
// {
//     $errors = [];

//     if (!empty($upload_file) &&
//         check_file_ext($upload_file)) {
//         $errors[] = MSG_NOT_ABLE_EXT;
//     }

//     return $errors;
// }

//画像投稿
function check_file_ext($upload_file)
{
    $err = false;

    $file_ext = pathinfo($upload_file, PATHINFO_EXTENSION);
    if (!in_array($file_ext, EXTENTION)) {
        $err = true;
    }

    return $err;
}

//求人の一括編集・更新機能
function update_job_all(
    $job_id,
    $type,
    $j_address_prefectures,
    $j_address_detail,
    $employment,
    $station,
    $smoke,
    $commute,
    $transfer,
    $academic,
    $experience,
    $qualification,
    $salary,
    $allowance,
    $allowance_limit,
    $insurance1,
    $insurance2,
    $insurance3,
    $insurance4,
    $childcare_leave,
    $work_hours,
    $break_time,
    $holiday,
    $holiday_detail,
    $retirement,
    $retirement_remarks,
    $rehire,
    $trial_period,
    $trial_period_span,
    $trial_period_conditions,
    $trial_period_conditions_detail,
    $description,
    $e_tel,
    $e_tel_time,
    $e_email,
    $e_name,
    $e_others, 
    $image_name, 
    $job_title
) 
{
$dbh = connect_db();

    $sql = <<<EOM
    UPDATE
    jobs

    SET
    type = :type,
    j_address_prefectures = :j_address_prefectures,
    j_address_detail = :j_address_detail,
    employment = :employment,
    station = :station,
    smoke = :smoke,
    commute = :commute,
    transfer = :transfer,
    academic = :academic,
    experience = :experience,
    qualification = :qualification,
    salary = :salary,
    allowance = :allowance,
    allowance_limit = :allowance_limit,
    insurance1 = :insurance1,
    insurance2 = :insurance2,
    insurance3 = :insurance3,
    insurance4 = :insurance4,
    childcare_leave = :childcare_leave,
    work_hours = :work_hours,
    break_time = :break_time,
    holiday = :holiday,
    holiday_detail = :holiday_detail,
    retirement = :retirement,
    retirement_remarks = :retirement_remarks,
    rehire = :rehire,
    trial_period = :trial_period,
    trial_period_span = :trial_period_span,
    trial_period_conditions = :trial_period_conditions,
    trial_period_conditions_detail = :trial_period_conditions_detail,
    description = :description,
    e_tel = :e_tel,
    e_tel_time = :e_tel_time,
    e_email = :e_email,
    e_name = :e_name,
    e_others = :e_others,
    e_others = :e_others,
    e_others = :e_others,
    image1 = :image1,
    job_title =:job_title

    WHERE
        id = :id
    EOM;

    $stmt = $dbh->prepare($sql);
    // $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':type', $type, PDO::PARAM_STR);
    $stmt->bindValue(':j_address_prefectures', $j_address_prefectures, PDO::PARAM_STR);
    $stmt->bindValue(':j_address_detail', $j_address_detail, PDO::PARAM_STR);
    $stmt->bindValue(':employment', $employment, PDO::PARAM_STR);
    $stmt->bindValue(':station', $station, PDO::PARAM_STR);
    $stmt->bindValue(':smoke', $smoke, PDO::PARAM_STR);
    $stmt->bindValue(':commute', $commute, PDO::PARAM_STR);
    $stmt->bindValue(':transfer', $transfer, PDO::PARAM_STR);
    $stmt->bindValue(':academic', $academic, PDO::PARAM_STR);
    $stmt->bindValue(':experience', $experience, PDO::PARAM_STR);
    $stmt->bindValue(':qualification', $qualification, PDO::PARAM_STR);
    $stmt->bindValue(':salary', $salary, PDO::PARAM_STR);
    $stmt->bindValue(':allowance', $allowance, PDO::PARAM_STR);
    $stmt->bindValue(':allowance_limit', $allowance_limit, PDO::PARAM_STR);
    $stmt->bindValue(':insurance1', $insurance1, PDO::PARAM_STR);
    $stmt->bindValue(':insurance2', $insurance2, PDO::PARAM_STR);
    $stmt->bindValue(':insurance3', $insurance3, PDO::PARAM_STR);
    $stmt->bindValue(':insurance4', $insurance4, PDO::PARAM_STR);
    $stmt->bindValue(':childcare_leave', $childcare_leave, PDO::PARAM_STR);
    $stmt->bindValue(':work_hours', $work_hours, PDO::PARAM_STR);
    $stmt->bindValue(':break_time', $break_time, PDO::PARAM_STR);
    $stmt->bindValue(':holiday', $holiday, PDO::PARAM_STR);
    $stmt->bindValue(':holiday_detail', $holiday_detail, PDO::PARAM_STR);
    $stmt->bindValue(':retirement', $retirement, PDO::PARAM_STR);
    $stmt->bindValue(':retirement_remarks', $retirement_remarks, PDO::PARAM_STR);
    $stmt->bindValue(':rehire', $rehire, PDO::PARAM_STR);
    $stmt->bindValue(':trial_period', $trial_period, PDO::PARAM_STR);
    $stmt->bindValue(':trial_period_span', $trial_period_span, PDO::PARAM_STR);
    $stmt->bindValue(':trial_period_conditions', $trial_period_conditions, PDO::PARAM_STR);
    $stmt->bindValue(':trial_period_conditions_detail', $trial_period_conditions_detail, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':e_tel', $e_tel, PDO::PARAM_STR);
    $stmt->bindValue(':e_tel_time', $e_tel_time, PDO::PARAM_STR);
    $stmt->bindValue(':e_email', $e_email, PDO::PARAM_STR);
    $stmt->bindValue(':e_name', $e_name, PDO::PARAM_STR);
    $stmt->bindValue(':e_others', $e_others, PDO::PARAM_STR);
    $stmt->bindValue(':image1', $image_name, PDO::PARAM_STR);
    $stmt->bindValue(':job_title', $job_title, PDO::PARAM_STR);
    $stmt->bindValue(':id', $job_id, PDO::PARAM_STR);

    $stmt->execute();
}

//求人の一括編集・更新機能(画像変更なしの場合)
function update_job_all_nochange_image(
    $job_id,
    $type,
    $j_address_prefectures,
    $j_address_detail,
    $employment,
    $station,
    $smoke,
    $commute,
    $transfer,
    $academic,
    $experience,
    $qualification,
    $salary,
    $allowance,
    $allowance_limit,
    $insurance1,
    $insurance2,
    $insurance3,
    $insurance4,
    $childcare_leave,
    $work_hours,
    $break_time,
    $holiday,
    $holiday_detail,
    $retirement,
    $retirement_remarks,
    $rehire,
    $trial_period,
    $trial_period_span,
    $trial_period_conditions,
    $trial_period_conditions_detail,
    $description,
    $e_tel,
    $e_tel_time,
    $e_email,
    $e_name,
    $e_others, 
    $job_title
) 
{
$dbh = connect_db();

    $sql = <<<EOM
    UPDATE
    jobs

    SET
    type = :type,
    j_address_prefectures = :j_address_prefectures,
    j_address_detail = :j_address_detail,
    employment = :employment,
    station = :station,
    smoke = :smoke,
    commute = :commute,
    transfer = :transfer,
    academic = :academic,
    experience = :experience,
    qualification = :qualification,
    salary = :salary,
    allowance = :allowance,
    allowance_limit = :allowance_limit,
    insurance1 = :insurance1,
    insurance2 = :insurance2,
    insurance3 = :insurance3,
    insurance4 = :insurance4,
    childcare_leave = :childcare_leave,
    work_hours = :work_hours,
    break_time = :break_time,
    holiday = :holiday,
    holiday_detail = :holiday_detail,
    retirement = :retirement,
    retirement_remarks = :retirement_remarks,
    rehire = :rehire,
    trial_period = :trial_period,
    trial_period_span = :trial_period_span,
    trial_period_conditions = :trial_period_conditions,
    trial_period_conditions_detail = :trial_period_conditions_detail,
    description = :description,
    e_tel = :e_tel,
    e_tel_time = :e_tel_time,
    e_email = :e_email,
    e_name = :e_name,
    e_others = :e_others,
    e_others = :e_others,
    e_others = :e_others,
    job_title =:job_title

    WHERE
        id = :id
    EOM;

    $stmt = $dbh->prepare($sql);
    // $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':type', $type, PDO::PARAM_STR);
    $stmt->bindValue(':j_address_prefectures', $j_address_prefectures, PDO::PARAM_STR);
    $stmt->bindValue(':j_address_detail', $j_address_detail, PDO::PARAM_STR);
    $stmt->bindValue(':employment', $employment, PDO::PARAM_STR);
    $stmt->bindValue(':station', $station, PDO::PARAM_STR);
    $stmt->bindValue(':smoke', $smoke, PDO::PARAM_STR);
    $stmt->bindValue(':commute', $commute, PDO::PARAM_STR);
    $stmt->bindValue(':transfer', $transfer, PDO::PARAM_STR);
    $stmt->bindValue(':academic', $academic, PDO::PARAM_STR);
    $stmt->bindValue(':experience', $experience, PDO::PARAM_STR);
    $stmt->bindValue(':qualification', $qualification, PDO::PARAM_STR);
    $stmt->bindValue(':salary', $salary, PDO::PARAM_STR);
    $stmt->bindValue(':allowance', $allowance, PDO::PARAM_STR);
    $stmt->bindValue(':allowance_limit', $allowance_limit, PDO::PARAM_STR);
    $stmt->bindValue(':insurance1', $insurance1, PDO::PARAM_STR);
    $stmt->bindValue(':insurance2', $insurance2, PDO::PARAM_STR);
    $stmt->bindValue(':insurance3', $insurance3, PDO::PARAM_STR);
    $stmt->bindValue(':insurance4', $insurance4, PDO::PARAM_STR);
    $stmt->bindValue(':childcare_leave', $childcare_leave, PDO::PARAM_STR);
    $stmt->bindValue(':work_hours', $work_hours, PDO::PARAM_STR);
    $stmt->bindValue(':break_time', $break_time, PDO::PARAM_STR);
    $stmt->bindValue(':holiday', $holiday, PDO::PARAM_STR);
    $stmt->bindValue(':holiday_detail', $holiday_detail, PDO::PARAM_STR);
    $stmt->bindValue(':retirement', $retirement, PDO::PARAM_STR);
    $stmt->bindValue(':retirement_remarks', $retirement_remarks, PDO::PARAM_STR);
    $stmt->bindValue(':rehire', $rehire, PDO::PARAM_STR);
    $stmt->bindValue(':trial_period', $trial_period, PDO::PARAM_STR);
    $stmt->bindValue(':trial_period_span', $trial_period_span, PDO::PARAM_STR);
    $stmt->bindValue(':trial_period_conditions', $trial_period_conditions, PDO::PARAM_STR);
    $stmt->bindValue(':trial_period_conditions_detail', $trial_period_conditions_detail, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':e_tel', $e_tel, PDO::PARAM_STR);
    $stmt->bindValue(':e_tel_time', $e_tel_time, PDO::PARAM_STR);
    $stmt->bindValue(':e_email', $e_email, PDO::PARAM_STR);
    $stmt->bindValue(':e_name', $e_name, PDO::PARAM_STR);
    $stmt->bindValue(':e_others', $e_others, PDO::PARAM_STR);
    $stmt->bindValue(':job_title', $job_title, PDO::PARAM_STR);
    $stmt->bindValue(':id', $job_id, PDO::PARAM_STR);

    $stmt->execute();
}

// 求人削除機能
function delete_job($id)
{
    $dbh = connect_db();

    $sql = <<<EOM
    DELETE 
        FROM 
    jobs 
        WHERE 
    id = :id
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// 求人掲載ステータス → 一時停止
function status_off($job_id)
{
$dbh = connect_db();

    $sql = <<<EOM
    UPDATE
        jobs
    SET
        status = false
    WHERE
        id = :id
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $job_id, PDO::PARAM_STR);
    $stmt->execute();
}

// 求人掲載ステータス → 掲載中
function status_on($job_id)
{
$dbh = connect_db();

    $sql = <<<EOM
    UPDATE
        jobs
    SET
        status = true
    WHERE
        id = :id
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $job_id, PDO::PARAM_STR);
    $stmt->execute();
}

///////////////////////
// ここから求人情報取得//
///////////////////////

// 求人情報と会社情報を全て取得(紐づけはcompany.id: jobs.company_id)
function find_com_job_all()
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT * 
    FROM companys 
    INNER JOIN jobs
    ON companys.id = jobs.company_id
    ORDER BY jobs.created_at DESC
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 求人情報のidをもとに会社情報を取得(show.php)
function find_com_job($id)
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT * 
    FROM companys 
    INNER JOIN jobs
    ON companys.id = jobs.company_id
    WHERE jobs.id=:id
    ORDER BY jobs.created_at DESC

    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 求人情報のidをもとに求人情報を取得(show.php)
function find_job_com($id)
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT * 
    FROM companys 
    INNER JOIN jobs
    ON companys.id = jobs.company_id
    WHERE companys.id=:id
    ORDER BY jobs.created_at DESC

    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 求人情報と会社情報を直近から3件取得(status:trueのみ)
function find_com_job_last3()
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT * 
    FROM companys 
    INNER JOIN jobs
    ON companys.id = jobs.company_id
    WHERE status = true
    ORDER BY jobs.created_at DESC
    LIMIT 3
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 求人情報と会社情報を$start~10件取得(status:trueのみ)
function find_com_job_last10($start)
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT *
    FROM companys
    INNER JOIN jobs
    ON companys.id = jobs.company_id
    WHERE status = true
    ORDER BY jobs.created_at DESC
    LIMIT :start,10
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 公開求人の件数取得(status:trueのみ)
function find_job_all_status_on_count()
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT COUNT(*)
    FROM jobs 
    WHERE status = true
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

///////////////////////
// ここから求人検索機能//
///////////////////////

// 公開求人>都道府県の件数取得(status:trueのみ)
function search_com_job_count($address_keyword,$type_keyword,$employment_keyword)
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT COUNT(*)
    FROM companys 
    INNER JOIN jobs
    ON companys.id = jobs.company_id
    WHERE j_address_prefectures LIKE :j_address_prefectures
    AND type LIKE :type
    AND employment LIKE :employment
    AND status = true
    EOM;

    $address_keyword_param = '%' . $address_keyword . '%';
    $type_keyword_param = '%' . $type_keyword . '%';
    $employment_keyword_param = '%' . $employment_keyword . '%';

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':j_address_prefectures', $address_keyword_param, PDO::PARAM_STR);
    $stmt->bindParam(':type', $type_keyword_param, PDO::PARAM_STR);
    $stmt->bindParam(':employment', $employment_keyword_param, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 公開求人>都道府県or職種or雇用形態の検索結果 10件取得(status:trueのみ)
function search_com_job($start,$address_keyword,$type_keyword,$employment_keyword)
{
    // データベースに接続
    $dbh = connect_db();

    // SQL文の組み立て
    $sql = <<<EOM
    SELECT * 
    FROM companys 
    INNER JOIN jobs
    ON companys.id = jobs.company_id
    WHERE j_address_prefectures LIKE :j_address_prefectures
    AND type LIKE :type
    AND employment LIKE :employment
    AND status = true

    ORDER BY jobs.created_at DESC
    LIMIT :start,10
    EOM;

    $address_keyword_param = '%' . $address_keyword . '%';
    $type_keyword_param = '%' . $type_keyword . '%';
    $employment_keyword_param = '%' . $employment_keyword . '%';

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':j_address_prefectures', $address_keyword_param, PDO::PARAM_STR);
    $stmt->bindParam(':type', $type_keyword_param, PDO::PARAM_STR);
    $stmt->bindParam(':employment', $employment_keyword_param, PDO::PARAM_STR);
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->execute();

    $search_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $search_result;
}

// 公開求人>都道府県の検索結果 10件取得(status:trueのみ)
// function search_address_com_job($start,$address_keyword)
// {
//     // データベースに接続
//     $dbh = connect_db();

//     // SQL文の組み立て
//     $sql = <<<EOM
//     SELECT * 
//     FROM companys 
//     INNER JOIN jobs
//     ON companys.id = jobs.company_id
//     WHERE j_address_prefectures LIKE :j_address_prefectures
//     AND status = true

//     ORDER BY jobs.created_at DESC
//     LIMIT :start,10
//     EOM;

//     $address_keyword_param = '%' . $address_keyword . '%';

//     $stmt = $dbh->prepare($sql);
//     $stmt->bindParam(':j_address_prefectures', $address_keyword_param, PDO::PARAM_STR);
//     $stmt->bindParam(':start', $start, PDO::PARAM_INT);
//     $stmt->execute();

//     $search_address_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     return $search_address_result;
// }

// 公開求人>都道府県の件数取得(status:trueのみ)
// function search_address_com_job_count($address_keyword)
// {
//     $dbh = connect_db();

//     $sql = <<<EOM
//     SELECT COUNT(*)
//     FROM jobs 
//     WHERE j_address_prefectures LIKE :j_address_prefectures
//     AND status = true
//     EOM;

//     $address_keyword_param = '%' . $address_keyword . '%';

//     $stmt = $dbh->prepare($sql);
//     $stmt->bindParam(':j_address_prefectures', $address_keyword_param, PDO::PARAM_STR);
//     $stmt->execute();

//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }

// 公開求人>職種の件数取得(status:trueのみ)
function search_type_com_job_count($type_keyword)
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT COUNT(*)
    FROM jobs 
    WHERE j_address_prefectures LIKE :j_address_prefectures
    AND status = true
    EOM;

    $type_keyword_param = '%' . $type_keyword . '%';

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':j_address_prefectures', $type_keyword_param, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 公開求人>雇用形態の件数取得(status:trueのみ)
function search_employment_com_job_count($employment_keyword)
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT COUNT(*)
    FROM jobs 
    WHERE j_address_prefectures LIKE :j_address_prefectures
    AND status = true
    EOM;

    $employment_keyword_param = '%' . $employment_keyword . '%';

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':j_address_prefectures', $employment_keyword_param, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

////////////////////////
// 検索>公開中の求人件数//
////////////////////////
// 公開求人件数>検索結果に該当した件数(// 純粋なカウント数をここで作っておく)
function find_job_count_true($job_count,$job_search_count,$address_keyword,$type_keyword,$employment_keyword)
{
    if(empty($address_keyword)){ //都道府県がemptyなら公開中の求人件数が返ってくる
    $job_count_true = $job_search_count;
    } elseif (!empty($address_keyword)){ //都道府県が!emptyなら公開中>都道府県の求人件数が返ってくる
    $job_count_true = $job_search_count;
    } elseif (!empty($type_keyword)){ //職種が!emptyなら公開中>職種の求人件数が返ってくる
    $job_count_true = $job_search_count;
    } elseif (!empty($employment_keyword)){ //雇用形態が!emptyなら公開中>雇用形態の求人件数が返ってくる
    $job_count_true = $job_search_count;
    }
return $job_count_true;
}

// urlに[address=]の値があれば値を返す
function add_url($address_keyword)
{
if (!empty($address_keyword)) {
    return "&address=". h($address_keyword);
}
}

// urlに[type=]の値があれば値を返す
function type_url($type)
{
if (!empty($type)) {
    return "&type=". h($type);
}
}

// urlに[employment=]の値があれば値を返す
function emp_url($employment)
{
if (!empty($employment)) {
    return "&employment=". h($employment);
}
}


function paging($page, $address_keyword,$find_job_count_true,$type_keyword,$employment_keyword)
{
$page = (int) htmlspecialchars($page);

$prev = max($page - 1, 1); // 前のページ番号
$next = $page + 1; // 次のページ番号

if ($page > 1) { // 最初のページ以外で「前へ」を表示
    print '<a href="?page=' . $prev . add_url($address_keyword) . type_url($type_keyword) . emp_url($employment_keyword) . '">&laquo; 前へ</a>';
}
if ($find_job_count_true - (intval($page)*10) > 0){ // 最後のページ以外で「次へ」を表示
    print '<a href="?page=' . $next . add_url($address_keyword) . type_url($type_keyword) . emp_url($employment_keyword) .'">次へ &raquo;</a>';
}
}
