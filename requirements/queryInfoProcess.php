<?php error_reporting(0); ?>
<?php
/*
接受详细信息查询，并给予结果
*/


include_once dirname(__FILE__) . '/global.php';
include_once dirname(__FILE__) . '/opertions.php';


function poetryInfo($title, $author) {
  if ($title && $author) {

    // 封装响应信息
    $return_array = [];
    $sql_query_res = queryDetail($title, $author);
    if ($sql_query_res['status'] == 200) {
      $return_array['result'] = $sql_query_res['result'];
      $return_array['status'] = 200;
      ob_clean();
      return $return_array;
    }
    else {
      if ($sql_query_res['status'] == 500) {
        ob_clean();
        return ['result' => null, 'status' => 500];
      }
      else {
        ob_clean();
        return ['result' => 'invalid', 'status' => 403];
      }
    }
  }
  else {
    ob_clean();
    return ['result' => null, 'status' => 400];
  }
}

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  redirect('/login.php');
}