<?php
require('facebook.php');
require('vendor/rb.php');

$group_id = '263827920387171';

if(!isset($_SESSION['facebook_access_token'])) {
	die('not authenticated');
} else if(!isset($_REQUEST['action'])) {
	die('action required');
} else {
	$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	$action = $_REQUEST['action'];
}

if($action === 'posts') {
	header('Content-Type: text/json');
	$posts = getPosts();
	$locations = extractLocations($posts['data']);
	//$details = getPostDetails($posts);
	echo json_encode(array(
		'posts'=>$posts,
		'locations'=>$locations
	));
} else if($action === 'post-details') {
	header('Content-Type: text/json');
} else if($action === 'genders') {
	header('Content-Type: text/json');
	$names = explode(",", $_REQUEST['names']);
	$genders = getGenders($names);
	echo json_encode($genders);
}

function getPostDetails($posts) {
	global $fb;
	$details = array();
	foreach($posts as $post) {
		$id = $post['id'];
		$response = $fb->sendRequest("GET", "/$id", array('fields'=>'created_time,from'));
		$details[$post['id']] = $response->getDecodedBody(); 
	}
	return $details;
}

function getPosts() {
	global $fb, $group_id;
	$response = $fb->sendRequest("GET", "/$group_id/feed", array('limit'=>25, 'fields'=>'message,id,updated_time,from'));
	return $response->getDecodedBody();
}

function getGenders($names) {
	connect();
	$genders = array();
	foreach($names as $name) {
		$genders[$name] = getGenderDetails($name);
	}
	return $genders;
}

function getGenderDetails($firstname) {
	global $fb;
	$rows = R::getAssocRow("SELECT gender FROM names WHERE firstname=?", array($firstname));
	if(count($rows))
		return $rows[0]['gender'];
	else {
		$response = file_get_contents("https://api.genderize.io/?name=$firstname");
		$data = json_decode($response, true);
		if($data['gender'] === null) {
			$data['probability'] = 0;
			$data['count'] = 0;
		}
		R::exec("INSERT INTO names (firstname,gender,probability,count) VALUES (?,?,?,?)", 
			array($firstname, $data['gender'], $data['probability'], $data['count']));
		return $data['gender'];
	}
}

function connect() {
	if(isset($_SERVER['OPENSHIFT_MYSQL_DB_HOST'])) {
		$DB_NAME = 'estatescraper';
		$DB_PASS = $_SERVER['OPENSHIFT_MYSQL_DB_PASSWORD'];
		$DB_USER = $_SERVER['OPENSHIFT_MYSQL_DB_USERNAME'];
		$DB_HOST = $_SERVER['OPENSHIFT_MYSQL_DB_HOST'];
	} else {
		$config = parse_ini_file('env.ini');
		$DB_NAME = $config['DB_NAME'];
		$DB_PASS = $config['DB_PASS'];
		$DB_USER = $config['DB_USER'];
		$DB_HOST = $config['DB_HOST'];
	}
	R::setup("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS); 
}

function extractLocations($posts) {
	$locations = explode("\n", file_get_contents('data/locations.csv'));
	for($i = 0; $i < count($locations); $i++)
		$locations[$i] = strtolower($locations[$i]);
	$references = array();
	foreach($posts as $post) {
		//$post = strtolower($post);
		/*foreach($locations as $loc) {
			if(strpos($post, $loc) !== false) {
				if(!isset($references[$loc]))
					$references[$loc] = array();
				array_push($references[$loc], $post['id']);
			}
		} */
	}
	//return $references;
	return $locations;
}

?>