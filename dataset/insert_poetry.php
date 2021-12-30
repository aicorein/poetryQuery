<?php
/*
  唐诗数据表插入数据
*/
define('endl', '<br>');

$dbhost = '';
$dbuser = '';
$dbpwd = '';
$dbname = '';
$dbtable = '';

$poetry_data = [];
for ($i = 0; $i <= 57000; $i += 1000) {
  $file_path = './poet.tang.' . strval($i) . '.json';
  $json_string = file_get_contents($file_path);
  $poetry_data = array_merge($poetry_data, json_decode($json_string, true));
}

$db = mysqli_connect($dbhost, $dbuser, $dbpwd);
if (!$db) {
  die('Could not connect.');
}
mysqli_select_db($db, $dbname);

foreach ($poetry_data as $poetry) {
  $title = $poetry['title'];
  $author = $poetry['author'];
  $paragraphs = join('\n', $poetry['paragraphs']);
  $id = $poetry['id'];
  if (strlen($title) > 130) {
    continue;
  }

  $sql_string = "INSERT INTO `$dbtable` ".
              "(id,title,author,paragraphs) ".
              "VALUES ".
              "('$id','$title','$author','$paragraphs')";
  $retval = mysqli_query($db, $sql_string);
  if (!$retval) {
    echo $title.endl.$author.endl.$paragraphs.endl.$id;
    die('Could not insert data: ' . mysqli_error($db));
  }
}

mysqli_close($db);

echo "Finish operation.";