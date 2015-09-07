<?php 
require('facebook.php');

$logged_in = true;

if( isset($_SESSION['facebook_access_token']) ) {
	$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	try {
		$me = $fb->get('/me');
		if(!$me)
			$logged_in = false;
	} catch(Facebook\Exceptions\FacebookApiException $e) {
		$logged_in = false;
	}
} else {
	$logged_in = false;
}

if($logged_in) {
	header('Location: /home.php');
} else {
	header('Location: /login.php');
}

?>