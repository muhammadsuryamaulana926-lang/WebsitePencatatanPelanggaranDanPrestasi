<?php
$str = file_get_contents('composer_output.txt');
$str = mb_convert_encoding($str, 'UTF-8', 'UTF-16LE');
file_put_contents('composer_error_readable.txt', $str);
