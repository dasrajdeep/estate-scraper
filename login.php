<?php
require('facebook.php');

$helper = $fb->getRedirectLoginHelper();
$permissions = [];
$loginUrl = $helper->getLoginUrl('http://estatescraper-octane.rhcloud.com:8080/login-callback.php', $permissions);

?>

<html>
	<head>
		<title>Estate Scraper</title>
		<link rel="stylesheet" href="vendor/bootstrap.min.css" />
		<script type="text/javascript" src="vendor/bootstrap.min.js"></script>
	</head>
	
	<body class="text-center">
		<h1>Estate Scraper</h1>
		<div><a href="<?php echo $loginUrl; ?>">Login with Facebook</a></div>
	</body>
</html>