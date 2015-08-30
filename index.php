<html>

<head>
	<title>Estate Scraper</title>
	<link rel="stylesheet" href="bootstrap.min.css" />
	<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap.min.js"></script>
	<script type="text/javascript" src="moment.min.js"></script>
	<script type="text/javascript" src="levenshtein.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
	<style>
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
			background-color: #EEEEEE;
		}
	</style>
</head>

<body>
	<div class="container">
		<h3 class="pull-right" id="num-posts"></h3>
		<h1>Recent Posts</h1>
		<div class="clearfix"></div>
		<div id="all-locations"></div>
		<hr/>
		<div>
			<input type="radio" name="gender" value="male" /> Male
			<input type="radio" name="gender" value="female" /> Female
			<input type="radio" name="gender" value="nogender" /> Neutral
			<input type="radio" name="gender" value="all" checked="checked" /> All
		</div>
		<div id="posts">Loading...</div>
	</div>
</body>

</html>