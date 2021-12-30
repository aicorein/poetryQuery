<!-- 登录控制页 -->
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="UTF-8">
  <title>登录页</title>
  <link rel="stylesheet" href="/css/login.css"></link>
  <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
<?php error_reporting(0); ?>
  <?php
  include_once dirname(__FILE__) . '/requirements/global.php';
  include_once dirname(__FILE__) . '/requirements/opertions.php';
  ?>

  <?php if ($_SERVER['REQUEST_METHOD'] == 'GET') : ?>
    <?php if (isset($_COOKIE['user'])) : redirect('/query.php'); ?>
    <?php else : ?>
      <div class="login-box">
        <h1>唐诗查询系统登录</h1>
        <form action="/login.php" method="POST">
          <div>
            <label for="account">用户名：</label>
            <input type="text" name="account" id="account">
          </div>
          <div>
            <label for="pwd">密码：</label>
            <input type="password" name="pwd" id="pwd">
          </div>
          <button id="toLogin">登 录</button>
        </form>
      </div>
      <script src="/js/login.js"></script>
    <?php endif ?>
  <?php else : ?>
    <?php if ($_POST['account'] == UNAME && $_POST['pwd'] == UPWD) :
      setcookie("user", "admin", time() + 3600);
      redirect('/query.php');
    ?>
    <?php else : ?>
        <div class="login-box">
          <h1>唐诗查询系统登录</h1>
          <form action="/login.php" method="POST">
            <div>
              <label for="account">用户名：</label>
              <input type="text" name="account" id="account">
            </div>
            <div>
              <label for="pwd">密码：</label>
              <input type="password" name="pwd" id="pwd">
            </div>
            <div class="status"><?php LoginFailedTip() ?></div>
            <button id="toLogin">登 录</button>
          </form>
        </div>
      <script src="/js/login.js"></script>
    <?php endif ?>
  <?php endif; ?>

</body>

</html>