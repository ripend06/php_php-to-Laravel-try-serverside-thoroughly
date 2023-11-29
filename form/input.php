<?php

//CSRF対策
session_start();

require './validation.php';

//クリックジャッキング対策
header('X-FRAME_OPTIONS:DENY');


//スパーグローバル変数 php ９種類
//連想配列
// if(!empty($_SESSION)) {
//     echo '<pre>';
//     var_dump($_SESSION);
//     echo '<pre>';
// }

if(!empty($_POST)) {
    echo '<pre>';
    var_dump($_POST);
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
$errors = validation($_POST); //判定した結果が入ってきてほしい。returnで返される


if(!empty($_POST['btn_confirm']) && empty($errors)){ //POSTが殻ではないかつエラーがからだったら処理
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

<?php //入力画面にもエラーを表示したい
    //エラーが入っているかつ、btn_confirmが空じゃないなら処理。
    //!empty($errorsだけだと初めてフォームを表示したときもエラー表示されちゃうので。＆＆が必要
    if(!empty($errors && !empty($_POST['btn_confirm'])) ): ?>
        <?php echo'<ul>'; ?>
            <?php
            foreach($errors as $error) {
                echo '<li>' . $error . '</li>';
            }
            ?>
        <?php echo'</ul>'; ?>
<?php endif; ?>
    <form method="POST" action="input.php">
        氏名
        <input type="text" name="your_name" value="<?php if(!empty($_POST['your_name'])){echo h($_POST['your_name']) ;} ?>">
        <br>
        メールアドレス
        <input type="text" name="email" value="<?php if(!empty($_POST['email'])){echo h($_POST['email']) ;} ?>">
        <br>
        ホームページ
        <input type="text" name="url" value="<?php if(!empty($_POST['url'])){echo h($_POST['url']) ;} ?>">
        <br>
        性別
        <!-- !issetを使う。!enptyは0でもtrueになるため -->
        <input type="radio" name="gender" value="0"
        <?php if(isset($_POST['gender']) && $_POST['gender'] === '0') //genderが入ってるかつ0ならcjecked出力
        { echo 'checked'; } ?>>男性
        <input type="radio" name="gender" value="1"
        <?php if(isset($_POST['gender']) && $_POST['gender'] === '1') //genderが入ってるかつ1ならcjecked出力
        { echo 'checked'; } ?>>女性
        <br>
        年齢
        <select name="age" id="">
            <option value="">選択してください</option>
            <option value="1" selected>〜１９歳</option>
            <option value="2">２０歳〜２９歳</option>
            <option value="3">３０歳〜３９歳</option>
            <option value="4">４０歳〜４９歳</option>
            <option value="5">５０歳〜５９歳</option>
            <option value="6">６０歳〜</option>
        </select>
        <br>
        お問い合わせ内容
        <textarea name="contact" id="" cols="30" rows="10">
        <?php if(!empty($_POST['contact'])){echo h($_POST['contact']) ;} ?>
        </textarea>
        <br>
        注意事項のチェック
        <input type="checkbox" name="caution" value="1"><!-- 複数の場合は、name="caution[]" -->
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
<?php if($_POST['csrf'] === $_SESSION['csrfToken']) :?>
    <form method="POST" action="input.php">
        氏名
        <?php echo h($_POST['your_name']) ;?>
        <br>
        メールアドレス
        <?php echo h($_POST['email']) ;?>
        <br>
        ホームページ
        <?php echo h($_POST['url']) ;?>
        <br>
        性別
        <?php if($_POST['gender'] === '0'){ echo '男性';}; ?>
        <?php if($_POST['gender'] === '1'){ echo '女性';}; ?>
        <br>
        年齢
        <?php if($_POST['age'] === '1'){ echo '〜19歳';}; ?>
        <?php if($_POST['age'] === '2'){ echo '20〜29歳';}; ?>
        <?php if($_POST['age'] === '3'){ echo '30〜39歳';}; ?>
        <?php if($_POST['age'] === '4'){ echo '40〜49歳';}; ?>
        <?php if($_POST['age'] === '5'){ echo '50〜59歳';}; ?>
        <?php if($_POST['age'] === '6'){ echo '60歳〜';}; ?>
        <br>
        お問い合わせ内容
        <?php echo h($_POST['contact']) ;?>
        <!-- <input type="checkbox" name="sports[]" value="野球">野球
        <input type="checkbox" name="sports[]" value="サッカー">サッカー
        <input type="checkbox" name="sports[]" value="バスケ">バスケ -->
        <!-- if文で制御してないので、戻るボタンは、前の画面に戻る-->
        <input type="submit" name="back" value="戻る">
        <input type="submit" name="btn_submit" value="送信する">
        <input type="hidden" name="your_name" value="<?php echo h($_POST['your_name']) ;?>">
        <input type="hidden" name="email" value="<?php echo h($_POST['email']) ;?>">
        <input type="hidden" name="url" value="<?php echo h($_POST['url']) ;?>">
        <input type="hidden" name="gender" value="<?php echo h($_POST['gender']) ;?>">
        <input type="hidden" name="age" value="<?php echo h($_POST['age']) ;?>">
        <input type="hidden" name="contact" value="<?php echo h($_POST['contact']) ;?>">

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