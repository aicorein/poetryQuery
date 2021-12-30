<?php
/*
  唐朝诗人数据表插入数据
*/
define('endl', '<br>');

$dbhost = '';
$dbuser = '';
$dbpwd = '';
$dbname = '';
$dbtable = '';

$file_path = './poet.tang.author.json';
$json_string = file_get_contents($file_path);
$poetry_data = json_decode($json_string, true);

$db = mysqli_connect($dbhost, $dbuser, $dbpwd);
if (!$db) {
  die('Could not connect.');
}
mysqli_select_db($db, $dbname);

foreach ($poetry_data as $poetry) {
  $name = $poetry['name'];
  $id = $poetry['id'];
  $desc = $poetry['desc'];

  $sql_string = "INSERT INTO `$dbtable` ".
              "(`id`,`name`,`desc`) ".
              "VALUES ".
              "('$id','$name','$desc')";
  $retval = mysqli_query($db, $sql_string);
  if (!$retval) {
    echo $name.endl.$desc.endl.$id;
    die('Could not insert data: ' . mysqli_error($db));
  }
}

mysqli_close($db);

echo "Finish operation.";
