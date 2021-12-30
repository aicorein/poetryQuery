<?php error_reporting(0); ?>
<?php
/*
定义操作
*/


include_once dirname(__FILE__) . '/global.php';


// 重定向函数
function redirect($url)
{
  header("Location: $url");
  exit();
}


// 设置一些 head 头并立即执行
function AlterHeader()
{
  header('Cache-Control:no-cache,must-revalidate');
  header('Pragma:no-cache');
  header('Content-Type: text/html; charset=utf-8');
}
AlterHeader();


// 登录验证失败
function LoginFailedTip()
{
  echo "验证失败，用户名不存在或密码错误！";
}


// 非法查询字符过滤
function check_param_safe($value = null)
{
  $str = '/select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/';
  if (preg_match($str, $value)) {
    return false;
  }
  return true;
}


// 匹配查询
function queryView($query_string) {
  $dbhost = LINK_HOST;
  $dbuser = DB_USER;
  $dbpwd = DB_PWD;
  $retval = [];
  $retval['status'] = 200;
  $retval['result'] = [];

  $db = mysqli_connect($dbhost, $dbuser, $dbpwd);

  if (!check_param_safe($query_string)) {
    $retval['status'] = 403;
    return $retval;
  }

  if (!$db) {
    $retval['status'] = 500;
    return $retval;
  }
  
  mysqli_select_db($db, DB_NAME);
  $table = POETRY_TABLE;
  $sql_string = "select title,author,paragraphs from $table ".
    "where paragraphs like '%$query_string%' ".
    "or title like '%$query_string%' ".
    "or author like '%$query_string%'";
  
  $query_res = mysqli_query($db, $sql_string);
  while($res = mysqli_fetch_assoc($query_res)) {
    array_push($retval['result'], $res);
  }
  
  for ($i = 0; $i < count($retval['result']); $i++) {
    $str = $retval['result'][$i]['paragraphs'];
    $paragraphs = array_unique(explode(',', str_replace("\n",",",$str)));

    if (strstr($retval['result'][$i]['title'], $query_string) || strstr($retval['result'][$i]['author'], $query_string)) {
      $retval['result'][$i]['paragraph'] = $paragraphs[0];
      unset($retval['result'][$i]['paragraphs']);
      continue;
    }

    foreach($paragraphs as $sentence) {
      if (strstr($sentence, $query_string)) {
        $retval['result'][$i]['paragraph'] = $sentence;
        unset($retval['result'][$i]['paragraphs']);
        break;
      }
    }
  }

  return $retval;
}

// 详细查询
function queryDetail($title, $author) {
  $dbhost = LINK_HOST;
  $dbuser = DB_USER;
  $dbpwd = DB_PWD;
  $retval = [];
  $retval['status'] = 200;
  $retval['result'] = [];

  $db = mysqli_connect($dbhost, $dbuser, $dbpwd);
  if (!$db) {
    $retval['status'] = 500;
    return $retval;
  }
  
  if (!check_param_safe($title) || !check_param_safe($author)) {
    $retval['status'] = 403;
    return $retval;
  }

  mysqli_select_db($db, DB_NAME);
  $author_table = AUTHOR_TABLE;
  $poetry_table = POETRY_TABLE;
  $sql_author_string = "select `desc` from $author_table where name='$author'";
  $sql_poetry_string = "select title,author,paragraphs from $poetry_table ".
    "where title='$title' ".
    "and author='$author'";
  
  $poetry_res = mysqli_fetch_assoc(mysqli_query($db, $sql_poetry_string));
  $str = $poetry_res['paragraphs'];
  $poetry_res['paragraphs'] = array_unique(explode(',', str_replace("\n",",",$str)));

  $desc_res = mysqli_fetch_assoc(mysqli_query($db, $sql_author_string));
  $retval['result'] = array_merge($poetry_res, $desc_res);
  return $retval;
}

// 非法访问控制
// print $_SERVER['PHP_SELF']."<br>".__FILE__;
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  redirect('/login.php');
}
