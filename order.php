<?php 
 if (isset($_COOKIE["NAHUI"])) {
 	header('Location: http://google.com/');
 	return;
	}
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) { $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP']; }
$ip = $_SERVER['REMOTE_ADDR'];
$fio = $_POST['name'];
$phone = $_POST['phone'];
$apiKey = '_5f882f3e1dd43953060118';
$stream = 'QpQS';
$clickid = $_POST['clickid'];
$marker = stripos($clickid, "clickid");
if($marker) 
    $clickid = substr($clickid, stripos($clickid, "clickid")+11);
$clickid = strtok($clickid, '"');
$sub1=$clickid;
$sub2 = $_POST['bay'];
$landing = 'pt1.coprv.com';
$referrer = 'facebook.com';
$country = 'pt';
$fbp = (isset($_GET['_fbp']) && !empty($_GET['_fbp'])) ? $_GET['_fbp'] : $_POST['fbp'];


if (isset($phone)) {
 

$params=array(
	'flow_hash' => $stream,
	'landing' => $landing,
	'country' => $country,
	'phone' => $phone,
	'name' => $fio,
	'sub1' => $sub1,
	'sub2' => $sub2,
	'referrer' => $referrer
);
$url = "http://wapi.leadbit.com/api/new-order/$apiKey";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_REFERER, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
$return = curl_exec($ch);
curl_close($ch);
setcookie("NAHUI", "123", time() + (3600 * 24));

date_default_timezone_set('Europe/Moscow');
$time = date('Y-m-d H:i:s');
$message = "$time;$fbp;$sub1;$sub2;$ip;$fio;$phone;$return\n";
file_put_contents('log.txt', $message, FILE_APPEND | LOCK_EX); 

header("Location: success.php?fbp=".$fbp."&name=".$_POST['name']."&phone=".$_POST['phone']);

exit;

} else {
   date_default_timezone_set('Europe/Moscow');
    $time = date('Y-m-d H:i:s');
    $message = "$time;$stream;$sub1;$ip;$fio;$phone;NO PHONE\n";
    file_put_contents('log.txt', $message, FILE_APPEND | LOCK_EX);
}

?>

