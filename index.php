<html>

<head>
	<title>Estate Scraper</title>
	<link rel="stylesheet" href="vendor/bootstrap.min.css" />
	<link rel="stylesheet" href="vendor/material/css/material.min.css" />
	<link rel="stylesheet" href="styles/main.css" />
	<script type="text/javascript" src="vendor/jquery.min.js"></script>
	<script type="text/javascript" src="vendor/bootstrap.min.js"></script>
	<script type="text/javascript" src="vendor/material/js/material.min.js"></script>
	<script type="text/javascript" src="vendor/moment.min.js"></script>
	<script type="text/javascript" src="vendor/levenshtein.min.js"></script>
	<script type="text/javascript" src="scripts/main.js"></script>
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
		<div id="posts">
			<div class="text-center"><img src="loader.gif" /></div>
		</div>
	</div>
</body>

</html>