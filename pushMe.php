<?php
//Usage: php pushMe.php (sandbox 1 password 123456 token xxx message 'push test')

//Params
$params = array(
	'sandbox' => 1,
	'token' => '8a1a83326f0aac18db063a2053c1e33b4842d96011f9191a67dc0d450a314d3c',
	'password' => '123456',
	'message' =>'PushMe Test Message!',
	);

if ($argc > 1){
	for ($i = 1; $i < $argc; $i+=2){
		$key = $argv[$i];
		$value = '';
		if ($i+1 < $argc) $value = $argv[$i+1];
		$params[$key] = $value;
	}
}
// print_r($params);

// Put your device token here (without spaces):
$deviceToken = $params['token'];

// Put your private key's passphrase here:
$passphrase = $params['password'];	//password

// Put your alert message here:
$message = $params['message'];

$host = 'ssl://gateway.push.apple.com:2195';
if ($params['sandbox'] == 1) $host = 'ssl://gateway.sandbox.push.apple.com:2195';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS db2_server_info(connection)
$fp = stream_socket_client(
	$host, $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default'
	);
$body['msgType'] = 'ORDER';

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	echo 'Message not delivered to '.$host . PHP_EOL;
else
	echo 'Message successfully delivered to '.$host . PHP_EOL;

// Close the connection to the server
fclose($fp);
