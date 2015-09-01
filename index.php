<html>

<head>
	<title>Estate Scraper</title>
	<link rel="stylesheet" href="bootstrap.min.css" />
	<link rel="stylesheet" href="material/css/material.min.css" />
	<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap.min.js"></script>
	<script type="text/javascript" src="material/js/material.min.js"></script>
	<script type="text/javascript" src="moment.min.js"></script>
	<script type="text/javascript" src="levenshtein.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
	<style>
		hr {
			border-color: #CCCCCC;
		}
		.location {
			color: blue;
		}
		.message {
			padding: 5px;
			border-radius: 3px;
		}
		.male .message {
			background-color: #99CCFF;
		}
		.female .message {
			background-color: #FFCCFF;
		}
		.nogender .message {
			background-color: #FFFFFF;
		}
	</style>
</head>

<body>
	<div class="container">
		<h3 class="pull-right" id="num-posts"></h3>
		<h1>
			<span id="group-name"></span>
			<br/>
			<small>Recent Posts</small>
		</h1>
		<div class="clearfix"></div>
		<div id="all-locations"></div>
		<hr/>
		<div class="radio radio-success">
			<label>
				<input type="radio" name="gender" value="male" /> Male
			</label>
			<label>
				<input type="radio" name="gender" value="female" /> Female
			</label>
			<label>
				<input type="radio" name="gender" value="nogender" /> Neutral
			</label>
			<label>
				<input type="radio" name="gender" value="all" checked="checked" /> All
			</label>
		</div>
		<div id="posts">Loading...</div>
	</div>
</body>

</html>