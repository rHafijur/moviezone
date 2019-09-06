/*Use onload event to load the page with random cars
*/
window.addEventListener("load", function(){
	if(window.location.search.substr(1)=='page=add_member'){
		makeAjaxGetRequest('moviezone_main.php', 'cmd_join_member', null, updateContent);
		document.getElementById('id_topnav').style.display = "none";
	}else{
	makeAjaxGetRequest('moviezone_main.php', 'cmd_movie_select_random', null, updateContent);
	//show the top navigation panel
	document.getElementById('id_topnav').style.display = "none";
	}
    
});

/*Handles onchange event to filter the car database
*/
function movieFilterChanged() {
	var director = document.getElementById('id_director').value;
	var actor = document.getElementById('id_actor').value;
	var genre = document.getElementById('id_genre').value;
	var studio = document.getElementById('id_studio').value;
	var params = '';
	if (director != 'all')
		params += '&director=' + director;
	if (actor != 'all')
		params += '&actor=' + actor;
	if (genre != 'all')
		params += '&genre=' + genre;
	if (!isNaN(studio))
		params += '&studio=' + studio;

	makeAjaxGetRequest('moviezone_main.php', 'cmd_movie_filter', params, updateContent);
}

/*Handles show all movies onlick event to show all movies
*/
function movieShowAllClick() {	
	makeAjaxGetRequest('moviezone_main.php','cmd_movie_select_all', null, updateContent);
	//hide the top navigation panel
	document.getElementById('id_topnav').style.display = "none";
}

/*Handles filter movies onclick event to filter movies
*/
function movieFilterClick() {
	//load the navigation panel on demand
	makeAjaxGetRequest('moviezone_main.php', 'cmd_show_top_nav', null, updateTopNav);
}
/*Handles join member request
*/
function showMemberJoinPage() {
	//load the navigation panel on demand
	makeAjaxGetRequest('moviezone_main.php', 'cmd_join_member', null, updateContent);
	document.getElementById('id_topnav').style.display = "none";
}

/*Updates the content area if success
*/
function updateContent(data) {
	document.getElementById('id_content').innerHTML = data;
}
/*Updates the top navigation panel
*/
function updateTopNav (data) {
	var topnav = document.getElementById('id_topnav');
	topnav.innerHTML = data;
	topnav.style.display = "inherit";
}