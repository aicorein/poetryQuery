<!-- 注销控制页 -->
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="UTF-8">
  <title>登出</title>
  <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
<?php error_reporting(0); ?>
  <?php
  include_once dirname(__FILE__) . '/requirements/global.php';
  include_once dirname(__FILE__) . '/requirements/opertions.php';

  if (isset($_COOKIE['user'])) {
    setcookie('user', 'admin', time() - 1);
  }
  redirect('/login.php');
  ?>

</body>

</html>