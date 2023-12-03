<?php
//１行ごと操作


$contactFile = '.contact.dat';

//1 開く fopen  a+は追記
$contents = fopen($contactFile, 'a+'); //オプションでモード選択する。+a 読み取り専用なのか書き込み専用なのかなど


$addText = '１行追記' . "\n";

//追記
fwrite($contents, $addText);

//閉じる
fclose($contents);


?>