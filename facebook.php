<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php'; 
	
$fb = new Facebook\Facebook([
    'app_id' => '1468310293496346',
    'app_secret' => '988befa1237a5a872ae8be33497f24d7',
    'default_graph_version' => 'v2.4',
]);
?>