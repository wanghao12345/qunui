<?php
header("content-type:text/html;charset=utf-8");

function DeleteAllCookies() {
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, null);
    }
}

if (@$_GET['delcookie'] == 1) {
    DeleteAllCookies();
}

if (@$_GET['setcookie'] == 1) {
    setcookie('test1', '123', time()+3600*24*30);
    setcookie('test2', '456', time()+3600*24*30);
    setcookie('test3', '789', time()+3600*24*30);
}

?>

<html>
<body>
    <?php if(@$_GET['delcookie'] == 1 || @$_GET['setcookie'] == 1) echo '<script> window.location.href="?" </script>'; ?>

    <a href="?setcookie=1">设置多个Cookie</a>
    <a href="?delcookie=1">删除Cookie</a>
    <div>
    <h2>当前Cookie</h2>
    <?php print_r($_COOKIE); ?>
    </div>
</body>
</html>