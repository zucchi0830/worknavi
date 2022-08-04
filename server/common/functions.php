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
    $e_others
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
        e_tel, e_tel_time, e_email, e_name, e_others)
    VALUES
        (:company_id, :status, :type, :j_address_prefectures, :j_address_detail, :employment, :station, :smoke, :commute, :transfer,
        :academic, :experience, :qualification, :salary, :allowance, :allowance_limit, :insurance1, :insurance2, :insurance3, :insurance4,
        :childcare_leave, :work_hours, :break_time, :holiday, :holiday_detail,
        :retirement, :retirement_remarks, :rehire, :trial_period, :trial_period_span,
        :trial_period_conditions, :trial_period_conditions_detail, :description,
        :e_tel, :e_tel_time, :e_email, :e_name, :e_others)
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

    $stmt->execute();
}

// 求人掲載用のエラーメッセージ表示(バリデーション)
function job_signup_validate(
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
    $e_name
) {
    $errors = [];

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

    return $errors;
}

// 求人情報と会社情報を全て取得(紐づけはcompany.id: jobs.company_id)
function find_com_job_all()
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT * 
    FROM companys 
    INNER JOIN jobs
    ON companys.id = jobs.company_id;
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 求人情報のidをもとに求人と会社情報を取得(show.php)
function find_com_job($id)
{
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT * 
    FROM companys 
    INNER JOIN jobs
    ON companys.id = jobs.company_id
    WHERE jobs.id=:id;

    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 求人編集・更新機能
function update_photo($id, $description)
{
    $dbh = connect_db();

    $sql = <<<EOM
    UPDATE
        jobs
    SET
        description = :description
    WHERE 
        id = :id
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);

    if (!empty($image_name)) {
        $stmt->bindValue(':image', $image_name, PDO::PARAM_STR);
    }

    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}


//求人の一括編集・更新機能 控え
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
    $e_others
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
    e_others = :e_others
        
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
    $stmt->bindValue(':id', $job_id, PDO::PARAM_STR);

    $stmt->execute();
}
//求人の一括編集・更新機能
function update_job_all2($job_id,$type)
{
$dbh = connect_db();

    $sql = <<<EOM
    UPDATE
        jobs
    SET
        type = :type

    WHERE
        id = :id
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':type', $type, PDO::PARAM_STR);
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
    id = :id;
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// 求人掲載ステータス → 一時停止
function status_stop($job_id)
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
    // $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':id', $job_id, PDO::PARAM_STR);
    $stmt->execute();
}


function status_start($job_id)
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
    // $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':id', $job_id, PDO::PARAM_STR);
    $stmt->execute();
}
