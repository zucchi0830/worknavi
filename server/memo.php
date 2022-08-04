<?php 
$insurances = '';
$insurance1 = '';
$insurance2 = '';
$insurance3 = ''; 
$insurance4 = '';
$sel_insurances = ['','労災保険', '労働保険', '健康保険', '厚生年金'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $insurance1 = filter_input(INPUT_POST, 'insurance1'); //労災保険
    $insurance2 = filter_input(INPUT_POST, 'insurance2'); //労働保険
    $insurance3 = filter_input(INPUT_POST, 'insurance3'); //健康保険
    $insurance4 = filter_input(INPUT_POST, 'insurance4'); //厚生年金
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form class="signup_form" action="" method="post">
<label class="insurances_label signup_label" for="insurances">社会保険<span class="asterisk">*</span></label>
<!-- ここから -->
    <?php if ($insurance1 == $sel_insurances[1]) : ?>
        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
        <?= "<input type='checkbox' name='insurance1' value='$sel_insurances[1]' id='$sel_insurances[1]' checked>" . "<label for='$sel_insurances[1]'>" . "$sel_insurances[1]". "</label>" ?>
    <?php else : ?>
        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
        <?= "<input type='checkbox' name='insurance1' value='$sel_insurances[1]' id='$sel_insurances[1]'>" . "<label for='$sel_insurances[1]'>" . "$sel_insurances[1]". "</label>" ?>
    <?php endif; ?>
    <?php if ($insurance2 == $sel_insurances[2]) : ?>
        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
        <?= "<input type='checkbox' name='insurance2' value='$sel_insurances[2]' id='$sel_insurances[2]' checked>" . "<label for='$sel_insurances[2]'>" . "$sel_insurances[2]". "</label>" ?>
    <?php else : ?>
        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
        <?= "<input type='checkbox' name='insurance2' value='$sel_insurances[2]' id='$sel_insurances[2]'>" . "<label for='$sel_insurances[2]'>" . "$sel_insurances[2]". "</label>" ?>
    <?php endif; ?>
    <?php if ($insurance3 == $sel_insurances[3]) : ?>
        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
        <?= "<input type='checkbox' name='insurance3' value='$sel_insurances[3]' id='$sel_insurances[3]' checked>" . "<label for='$sel_insurances[3]'>" . "$sel_insurances[3]". "</label>" ?>
    <?php else : ?>
        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
        <?= "<input type='checkbox' name='insurance3' value='$sel_insurances[3]' id='$sel_insurances[3]'>" . "<label for='$sel_insurances[3]'>" . "$sel_insurances[3]". "</label>" ?>
    <?php endif; ?>
    <?php if ($insurance4 == $sel_insurances[4]) : ?>
        <!-- ① POST データが存在する場合はこちらの分岐に入る -->
        <?= "<input type='checkbox' name='insurance4' value='$sel_insurances[4]' id='$sel_insurances[4]' checked>" . "<label for='$sel_insurances[4]'>" . "$sel_insurances[4]". "</label>" ?>
    <?php else : ?>
        <!-- ② POST データが存在しない場合はこちらの分岐に入る -->
        <?= "<input type='checkbox' name='insurance4' value='$sel_insurances[4]' id='$sel_insurances[4]'>" . "<label for='$sel_insurances[4]'>" . "$sel_insurances[4]". "</label>" ?>
    <?php endif; ?>
<!-- ここまでを短くしたい -->
    
    <input type="submit" value="求人情報を掲載する" class="signup_button">
</form>
</body>
</html>
