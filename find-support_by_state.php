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
$stmt = $mysqli->prepare("SELECT * FROM clinic_info WHERE clinic_state = ?");
$stmt->bind_param("s", $city);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0) exit('No rows');

class Clinic{
    public $id;
    public $organization;
    public $state;
    public $name;
    public $street;
    public $latitude;
    public $longitude;
    public $phone;
    public $rate;
    public $ratenumber;
    public $website;
};
$response = array();
 while ($row = $result->fetch_array()) {
          $clinic = new Clinic();
          $clinic->id = $row['clinic_id'];
          $clinic->organization = $row['clinic_organization'];
          $clinic->state =  $row['clinic_state'];
          $clinic->name = $row['clinic_name'];
          $clinic->street = $row['clinic_street'];
          $clinic->latitude = $row['clinic_lat'];
          $clinic->longitude = $row['clinic_lon'];
          $clinic->phone = $row['clinic_phone'];
          $clinic->rate = $row['clinic_rate'];
          $clinic->ratenumber = $row['clinic_rating_number'];
          $clinic->website = $row['clinic_website'];
          $response[]=$clinic;
}
$jsonobj = json_encode($response);
echo $jsonobj;
//$stmt->free();
$result->free();
$mysqli->close();
?>

