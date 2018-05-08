<?php
    header('Access-Control-Allow-Origin: *');
//	echo "hello world!";
//	echo $_GET['code'];
	header("Location: http://51weixingqun.com/index.php?code=".$_GET['code']); 
?>