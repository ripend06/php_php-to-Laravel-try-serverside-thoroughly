<?php

//パスワードを記録したファイルの場所
echo __FILE__;
// /Applications/MAMP/htdocs/_workspace/PHP-Project/php_php-to-Laravel-try-serverside-thoroughly/mainte/test.php

//パスワード暗号化
echo'<br>';
echo(password_hash('password123', PASSWORD_BCRYPT)); //password_hashで暗号化する
// $2y$10$UzPoURjQXs1W.5I0lX1Ik.KqzDdvuqrS.8i/9GVOBsqtkLD6XtkmC

?>