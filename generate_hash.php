<?php
$password = '123abcABC';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;
?> 