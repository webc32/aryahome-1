<?
 $t = preg_replace ('~([\/\*])\1+~', '\1', $_SERVER['REQUEST_URI']);
 echo $_SERVER['REQUEST_URI'];
 var_dump($t);