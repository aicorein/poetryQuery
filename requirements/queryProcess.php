<?php error_reporting(0); ?>
<?php
/*
接受查询的 POST 请求，并给予 response
*/


include_once dirname(__FILE__) . '/global.php';
include_once dirname(__FILE__) . '/opertions.php';

header('Content-Type: application/json;charset=utf-8');

if (isset($_COOKIE['user'])) {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['query_string'] != '' && $_POST['start_index'] != '') {

      $query_str = $_POST['query_string'];
      $start_index = $_POST['start_index'];
      $query_result = [];
      
      // 封装响应信息
      $return_array = [];
      $sql_query_res = queryView($query_str);
      if ($sql_query_res['status'] == 200) {
        $return_array['status'] = 200;
        $return_array['total'] = count($sql_query_res['result']);
        $return_array['result'] = array_slice($sql_query_res['result'], $start_index, 20);
        ob_clean();
        echo json_encode($return_array);
      }
      else {
        if ($sql_query_res['status'] == 500) {
          ob_clean();
          echo json_encode('[{"result": null, "status": "500"}]');
        }
        else {
          ob_clean();
          echo json_encode('[{"result": "invalid", "status": "403"}]');
        }
      }
    }
    else {
      ob_clean();
      echo json_encode('[{"result": null, "status": "400"}]');
    }
  } 
  else {
    redirect('/login.php');
  }
}
else {
  redirect('/login.php');
}
