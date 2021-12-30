<!-- 详细信息页 -->
<?php error_reporting(0); ?>
  <?php
  include_once dirname(__FILE__) . '/requirements/global.php';
  include_once dirname(__FILE__) . '/requirements/opertions.php';
  include_once dirname(__FILE__) . '/requirements/queryInfoProcess.php';
  ?>

  <?php if (isset($_COOKIE['user'])) : ?>
    <?php if ($_GET['title'] && $_GET['author']): 
      $infoArray = poetryInfo($_GET['title'], $_GET['author']);
      if ($infoArray['status'] == 200 && !empty($infoArray['result'])) {
        $paragraphs = $infoArray['result']['paragraphs'];
        echo "<script>document.title = '{$infoArray['result']['title']} - {$infoArray['result']['author']}'</script>";
        if ($infoArray['result']['desc'] == '') {
          $infoArray['result']['desc'] = '暂无简介';
        }
      }
      else {
        echo "<script>alert('查询结果不存在，将自动返回查询页!')</script>";
        redirect('/query.php');
      }
    ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="UTF-8">
  <title>详细页</title>
  <link rel="stylesheet" href="/css/queryInfo.css">
  <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
      <div class="content-box">
        <div class="poetry-content">
          <h1 class="title"><?= $_GET['title'] ?></h1>
          <div class="author"><?= $_GET['author'] ?></div>
          <div class="paragraphs"><?php foreach($paragraphs as $sentence) echo "<p>".$sentence."</p>"; ?></div>
        </div>
        <div class="desc">
          <h2>作者简介：</h2>
          <div class="text"><?= $infoArray['result']['desc'] ?></div>
        </div>
      </div>
    <?php else: ?>
      <script>alert('参数为空，查询失败！')</script>
      <?php redirect('/query.php'); ?>
    <?php endif ?>
  <?php else :  redirect('/login.php') ?>
  <?php endif ?>

</body>

</html>