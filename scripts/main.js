// Main script

var groupID = '263827920387171';
var locations = null;
var limit = 100;

var showingGender = 'all';
var showingLocation = 'all';

var postedLocations = {};

$(document).ready(function() {
	$.get('data/locations.csv', {}, function(response) {
		locations = response.split("\n");
		for(var i = 0; i < locations.length; i++)
			locations[i] = locations[i].substring(1, locations[i].length - 2).toLowerCase();
			//locations[i] = locations[i].replace(/"/g, '').toLowerCase();
		$.ajaxSetup({
			cache: true
		});
		$.getScript('http://connect.facebook.net/en_US/sdk.js', function() {
			FB.init({
				appId: '1468310293496346',
				version: 'v2.4' 
			});
			$('#loginbutton,#feedbutton').removeAttr('disabled');
			FB.getLoginStatus(function(response) {
				if (response.status === 'connected') {
					console.log('Logged in.');
					onLogin();
				} else {
					FB.login(onLogin);
				}
			});
		});
	});
	handlers();
	$.material.init();
});

function onLogin() {
	FB.api('/' + groupID, function(response) {
		if (!response || response.error)
			console.log('An error occurred!');
		else {
			$('#group-name').text(response.name);
		}	
	});
	FB.api('/' + groupID + '/feed', 'get', { limit: limit}, function(response) {
		if (!response || response.error)
			console.log('An error occurred!');
		else {
			var data = response.data;
			var paging = response.paging;
			displayPosts(data);
			searchLocations();
			fetchDetails();
		}
	});
}

function displayPosts(data) {
	var length = data.length;
	$('#num-posts').text(length + ' posts');
	$('#posts').html('');
	for(var i = 0; i < length; i++) {
		var time = moment(new Date(data[i].updated_time)); 
		var message = data[i].message ? data[i].message : '[NO_MESSAGE_CONTENT]';
		$('#posts').append(
			$('<div>')
			.attr('id', data[i].id)
			.addClass('post')
			.append(
				$('<hr>')
			).append(
				$('<div>')
					.addClass('message')
					.attr('data-id', data[i].id)
					.text(message)
			).append(
				$('<br>')
			).append(
				$('<b>').text(time.fromNow())
			).append(
				$('<i>').addClass('pull-right').text(time.format("dddd, MMMM Do YYYY, h:mm:ss a"))
			).append(
				$('<h5>').addClass('location')
			).append(
				$('<a>').attr({
					'href': 'https://www.facebook.com/groups/' + data[i].id.replace('_', '/'),
					'target': '_blank'
				}).text('Open in Facebook').addClass('btn btn-primary')
			)
		);
		$('#posts').append($('<div>').addClass('clearfix'));
	}
}

function searchLocations() {
	var msgIds = {};
	var genders = { 'male': [], 'female': [] };
	$('.message').each(function() {
		var text = $(this).text().toLowerCase();
		var id = $(this).attr('data-id');
		if(text.indexOf('female') >= 0 || text.indexOf('girl') >= 0)
			$(this).parent().addClass('female');
		else if(text.indexOf('male') >= 0 
			|| text.indexOf('boy') >= 0 
			|| text.indexOf('bachelor') >= 0 
			|| text.indexOf('occup') >= 0 
			|| text.indexOf('sharing') >= 0
			|| text.indexOf('apartment') >= 0
			|| text.indexOf('bhk') >= 0
			|| text.indexOf('mate') >= 0)
			$(this).parent().addClass('male');
		else
			$(this).parent().addClass('nogender');
		msgIds[id] = [];
		for(var i = 0; i < locations.length; i++) {
			if(text.indexOf(locations[i]) >= 0) {
				msgIds[id].push(locations[i]);
			} else {
				// TODO levenshtein 
			}
		}
		if(msgIds[id].length) {
			var loc = msgIds[id][0];
			for(var i = 1; i < msgIds[id].length; i++)
				loc = loc + ',' + msgIds[id][i];
		}
		$(this).parent().find('.location').text(loc);
	});
	for(var mid in msgIds) {
		var locs = msgIds[mid];
		for(var i = 0; i < locs.length; i++) {
			if(typeof postedLocations[locs[i]] === 'undefined')
				postedLocations[locs[i]] = [];
			postedLocations[locs[i]].push(mid);
		}
	}
	for(var loc in postedLocations) {
		$('#all-locations').append(
			$('<a>')
				.addClass('.filter-loc')
				.css({ 'text-decoration': 'none' })
				.text(loc)
				.attr({'data-loc': loc, 'href': ''})
				.click(function(e) {
					e.preventDefault();
					filter(null, $(this).attr('data-loc'));
				})
		).append($('<b>').text(' / '));
	}
	$('#all-locations').append(
		$('<a>')
			.addClass('.filter-loc')
			.css({ 'text-decoration': 'none' })
			.text('all locations')
			.attr({'data-loc': 'all', 'href': ''})
			.click(function(e) {
				e.preventDefault();
				filter(null, 'all');
			})
	);
}

function filter(gender, location) {
	$('.message').parent().hide();
	if(gender) showingGender = gender;
	if(location) showingLocation = location;
	console.log(showingGender + ':' + showingLocation);
	if(showingGender === 'all')
		gender = '';
	else
		gender = '.' + showingGender;
	if(showingLocation === 'all' && showingGender === 'all')
		$('.message').parent().show();
	else if(showingLocation === 'all')
		$(gender).show();
	else {
		var mids = postedLocations[showingLocation];
		for(var i = 0; i < mids.length; i++)
			$('#' + mids[i] + gender).show();
	}
}

function handlers() {
	$('input[name=gender]').click(function() {
		var gender = $(this).val();
		filter(gender, null);
	});
}

function fetchDetails() {
	$('.post').each(function() {
		var id = $(this).attr('id');
		FB.api('/' + id + '/comments', function(response) {
			if (!response || response.error)
				console.log(response.error);
			else {
				var interested = {};
				for(var i = 0; i < response.data.length; i++) {
					interested[response.data[i].id] = response.data[i].name;
				}
				$('#' + id).append($('<div>').addClass('badge pull-right').text(Object.keys(interested).length + ' people interested'));
			}
		});
	});
}