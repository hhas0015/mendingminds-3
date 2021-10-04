<?php
header('Content-Type:text/json;charset=utf-8');
$type= $_POST['text'];
$mysql_conf = array(
    'host'    => 'localhost',
    'db'      => 'mendingminds',
    'db_user' => 'webuser',
    'db_pwd'  => '1z2s3E4R',
    );
$mysqli = @new mysqli($mysql_conf['host'], $mysql_conf['db_user'], $mysql_conf['db_pwd']);
if ($mysqli->connect_errno) {
    die("could not connect to the database:\n" . $mysqli->connect_error);
}
$select_db = $mysqli->select_db($mysql_conf['db']);
if (!$select_db) {
    die("could not connect to the db:\n" .  $mysqli->error);
}
$stmt = $mysqli->prepare("SELECT * FROM app_info WHERE app_type1 = ?");
$stmt->bind_param("s", $type);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0) exit('No rows');

class App{
    public $id;
    public $name;
    public $rating;
    public $cost;
    public $type1;
    public $type2;
    public $type3;
    public $type4;
    public $type5;
    public $platform;
};
$response = array();
 while ($row = $result->fetch_array()) {
          $app = new App();
          $app->id = $row['app_id'];
          $app->name = $row['app_name'];
          $app->rating =  $row['app_rating'];
          $app->cost = $row['app_cost'];
          $app->type1 = $row['app_type1'];
          $app->type2 = $row['app_type2'];
          $app->type3 = $row['app_type3'];
          $app->type4 = $row['app_type4'];
          $app->type5 = $row['app_type5'];
          $app->platform = $row['app_platform'];
          $response[]=$app;
}
$jsonobj = json_encode($response);
echo $jsonobj;
//$stmt->free();
$result->free();
$mysqli->close();
?>

