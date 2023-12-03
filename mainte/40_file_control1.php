<?php
//ファイル丸ごと操作



$contactFile = '.contact.dat';

//ファイル丸ごと読み込み
$fileContents = file_get_contents($contactFile);

//echo $fileContents;



//ファイルに書き込み(上書き)
//ile_put_contents($contactFile, 'テストです');

$addText = 'テストです' . "\n";

//ファイルに書き込み(追記)
// file_put_contents($contactFile, $addText, FILE_APPEND);



//,ごとに改行する
//配列 file ,区切る explode, foreach
$allDate = file($contactFile); //配列として読み込む

foreach($allDate as $lineData){ //ひとつひとつ取り出す
    $lines = explode(',', $lineData); //explodeで,ごとに切り取る。これも配列になってるので、
    echo $lines[0]. '<br>'; //echoでひとつひとつ取り出す
    echo $lines[1]. '<br>';
    echo $lines[2]. '<br>';
}


?>