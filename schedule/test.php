<?php
$file=fopen('1.txt', 'a+');
fwrite($file, 'hello and good bye');
fclose($file);
?>