<?php
// ini_set('display_startup_errors', 1);
// ini_set('display_errors', 1);
// error_reporting(-1);
// error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
header("Access-Control-Allow-Origin: *");
require_once "Mail.php";

$from = 'n-alert@nithins.me'; 

$to = $_POST["email"]; 
$link =  $_POST["sub"];
$subject = 'Summary of your class'; 
$ftime = $_POST["ftime"];
$ttime = $_POST["ttime"];
$summary = $_POST["summary"];

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://text-monkey-summarizer.p.rapidapi.com/nlp/summarize",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "{ \"text\": \"".$summary."\"}",
	CURLOPT_HTTPHEADER => array(
		"accept: application/json",
		"content-type: application/json",
		"x-rapidapi-host: text-monkey-summarizer.p.rapidapi.com",
		"x-rapidapi-key: 3230f449d2msh85d69f60dd39ee8p101b93jsn1b8b3dcb6164"
	),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	$obj =  json_decode($response);
	$shortPoints="";
	for ($x = 0; $x < count($obj->snippets); $x++) {
    	$xx=$x+1;
  		$shortPoints = $shortPoints.$xx.". ".$obj->snippets[$x].'<br>';
	}
}

$body = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>N-Alert</title>
    <link href="bootstrap.min.css"  rel="stylesheet"/>
    <style>
        .head{
            background-color: #007bff;
            color: white;
            font-size: 40px;
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
        }
        .container{
            border: 2px solid #007bff;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="head">
        N-Notes
    </div>
    <div class="container">
   		<h3>Here\'s the summary of your class </h3>
        <br>
        Class Details : <br>
        <ul>
            <li>Metting link : '.$link.'</li>
            <li>From : '.$ftime.'</li>
            <li>To : '.$ttime.'</li>
        </ul>
        <p><h3>Important Points : </h3>'.$shortPoints.'</p><br><br>
        <p><h3>Total summary</h3>'.str_replace(".","<br>",$summary).'</p>
        <br><br>
        Yours Sincerely, <br>N-Notes <br>
        Show your love - <a href="https://www.buymeacoffee.com/nithins" target="_blank">Buy me a coffee</a>
        <hr>
    </div>
</body>
</html>';

$headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject,
	'MIME-Version' => 1,
    'Content-type' => 'text/html;charset=iso-8859-1'
);

$smtp = Mail::factory('smtp', array(
        'host' => 'ssl://beka.ivella',
        'port' => 'beka ivella',
        'auth' => true,
        'username' => 'n-alert@nithins.me', 
        'password' => 'beka ivella' 
    ));

// Send the mail
$mail = $smtp->send($to, $headers, $body);

//check mail sent or not
if (PEAR::isError($mail)) {
    echo '<p>'.$mail->getMessage().'</p>';
} else {
    echo '<p>Message successfully sent!</p>';
}

?>
