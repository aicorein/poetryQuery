<!-- 查询页 -->
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="UTF-8">
  <title>查询页</title>
  <link rel="stylesheet" href="/css/query.css">
  <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
<?php error_reporting(0); ?>
  <?php
  include_once dirname(__FILE__) . '/requirements/global.php';
  include_once dirname(__FILE__) . '/requirements/opertions.php';
  ?>

  <?php if (isset($_COOKIE['user'])) : ?>
    <div class="wrapper">
      <h1>欢迎来到唐诗查询系统</h1>
      <div class="search">
        <label for="query">输入以查询：</label>
        <div><input type="text" name="query_string" id="query"></div>
        <span><a href="/logout.php">退出登录</a></span>
      </div>
      <div class="count"></div>
      <div class="content-box"></div>
    </div>
    <script src="/js/query.js"></script>
    <script src="/js/toQueryInfo.js"></script>
  <?php else :  redirect('/login.php') ?>
  <?php endif ?>

</body>

</html>