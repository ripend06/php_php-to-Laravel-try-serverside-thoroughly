<?php

//CSRF対策
session_start();

//クリックジャッキング対策
header('X-FRAME_OPTIONS:DENY');


//スパーグローバル変数 php ９種類
//連想配列
if(!empty($_SESSION)) {
    echo '<pre>';
    var_dump($_SESSION);
    echo '<pre>';
}


//XSS対策
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
}


//入力、確認、完了　input.php, confirm.php, thanks.php
//CSEF 偽物のinput.php->悪意あるページに飛ばされる　情報抜き取られる
//input.php

$pageFlag = 0;

if(!empty($_POST['btn_confirm'])){
    $pageFlag = 1;
}

if(!empty($_POST['btn_submit'])){
    $pageFlag = 2;
}

?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<!-- 入力画面 -->
<?php if($pageFlag === 0 ) : ?>

<?php //CSRF対策
    if(!isset($_SESSION['csrfToken'])){ //issetでSESSIONが設定されていなかったら実行
        $csrfToken = bin2hex(random_bytes(32)); //ランダムな合言葉文字生成。bin2hexで16バイトに変換
        $_SESSION['csrfToken'] = $csrfToken; //SESSIONに合言葉を入れる
    }
    $token = $_SESSION['csrfToken']; //合言葉を変数に入れる
?>
    <form method="POST" action="input.php">
        氏名
        <input type="text" name="your_name" value="<?php if(!empty($_POST['your_name'])){echo h($_POST['your_name']) ;} ?>">
        <br>
        メールアドレス
        <input type="email" name="email" value="<?php if(!empty($_POST['email'])){echo h($_POST['email']) ;} ?>">
        <br>
        <!-- <input type="checkbox" name="sports[]" value="野球">野球
        <input type="checkbox" name="sports[]" value="サッカー">サッカー
        <input type="checkbox" name="sports[]" value="バスケ">バスケ -->
        <input type="submit" name="btn_confirm" value="確認する">
        <input type="hidden" name="csrf" value="<?php echo $token; ?>"><!-- hiddenでcsrfを次の画面に送る -->
    </form>

<?php endif; ?>


<!-- 確認画面 -->
<?php if($pageFlag === 1 ) : ?>
<!-- フォームから送られてきた合言葉　$POST['csrf']　が　SESSIONと一致しているかどうか判定 -->
<?php if($POST['csrf'] === $_SESSION['csrfToken']) :?>
    <form method="POST" action="input.php">
        氏名
        <?php echo h($_POST['your_name']) ;?>
        <br>
        メールアドレス
        <?php echo h($_POST['email']) ;?>
        <br>
        <!-- <input type="checkbox" name="sports[]" value="野球">野球
        <input type="checkbox" name="sports[]" value="サッカー">サッカー
        <input type="checkbox" name="sports[]" value="バスケ">バスケ -->
        <!-- if文で制御してないので、戻るボタンは、前の画面に戻る-->
        <input type="submit" name="back" value="戻る">
        <input type="submit" name="btn_submit" value="送信する">
        <input type="hidden" name="your_name" value="<?php echo h($_POST['your_name']) ;?>">
        <input type="hidden" name="email" value="<?php echo h($_POST['email']) ;?>">
        <input type="hidden" name="csrf" value="<?php echo h($_POST['csrf']) ;?>"><!-- hiddenでcsrfを次の画面に送る -->
    </form>

<?php endif; ?>
<?php endif; ?>


<!-- 完了画面 -->
<?php if($pageFlag === 2 ) : ?>
    <!-- フォームから送られてきた合言葉　$POST['csrf']　が　SESSIONと一致しているかどうか判定 -->
    <?php if($POST['csrf'] === $_SESSION['csrfToken']) :?>
    送信が完了しました

    <!-- セッション外れる　合言葉を外す -->
    <?php unset($_SESSION['csrfToken']) ;?>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>