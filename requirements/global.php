<?php error_reporting(0); ?>
<?php
/*
定义全局常量
*/

include_once dirname(__FILE__).'/opertions.php';

define('UNAME', '');
define('UPWD', '');
define('LINK_HOST', '');
define('DB_NAME', '');
define('POETRY_TABLE', '');
define('AUTHOR_TABLE', '');
define('DB_USER', '');
define('DB_PWD', '');

define('endl', '<br>');
define('tab', '&emsp;&emsp;&emsp;&emsp;');


// 非法访问控制
// print $_SERVER['PHP_SELF']."<br>".__FILE__;
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    redirect('/login.php');
}