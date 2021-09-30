<?php
header('Content-Type:text/json;charset=utf-8');
$city = $_POST['text'];
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
$stmt = $mysqli->prepare("SELECT * FROM clinic_info WHERE clinic_city = ?");
$stmt->bind_param("s", $_POST['text']);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0) exit('No rows');
/*
$sql = "select * from clinic_info where clinic_city='".$city."';";
$res = $mysqli->query($sql);
if (!$res) {
    die("sql error:\n" . $mysqli->error);
}
*/
class Clinic{
    public $id;
    public $name;
    public $street;
    public $latitude;
    public $longitude;
    public $phone;
    public $description;
    public $city;
};
$response = array();
 while ($row = $result->fetch_array()) {
//        echo "id:".$row['clinic_id'].",name:".$row['clinic_name'].",street:".$row['clinic_street'].",latitude:".$row['clinic_lat'].",logitude:".$row['clinic_lon'].",phone:".$row['clinic_phone'].",description:".$row['clinic_description'].",city:".$row['clinic_city']; 
/*
          $str = array();
          $str[] = 
                 "clinic".i=>array(
                                   "id"=>$row['clinic_id'],
                                   "name"=>$row['clinic_name']
                                  )
                  ;
*/
          $clinic = new Clinic();
          $clinic->id = $row['clinic_id'];
          $clinic->name = $row['clinic_name'];
          $clinic->street = $row['clinic_street'];
          $clinic->latitude = $row['clinic_lat'];
          $clinic->longitude = $row['clinic_lon'];
          $clinic->phone = $row['clinic_phone'];
          $clinic->description = $row['clinic_description'];
          $clinic->city = $row['clinic_city'];
          $response[]=$clinic;
}
$jsonobj = json_encode($response);
echo $jsonobj;
//$stmt->free();
$result->free();
$mysqli->close();
?>
