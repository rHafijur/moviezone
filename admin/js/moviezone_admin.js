/*Use onload event to load the page with random cars
*/
window.addEventListener("load", function(){
    makeAjaxGetRequest('moviezone_admin_main.php', null, null, updateContent);
	//show the top navigation panel
	document.getElementById('id_topnav').style.display = "none";
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

	makeAjaxGetRequest('moviezone_admin_main.php', 'cmd_movie_filter', params, updateContent);
}

/*Handles show all movies onlick event to show all movies
*/
function movieShowAllClick() {	
	makeAjaxGetRequest('moviezone_admin_main.php','cmd_movie_select_all', null, updateContent);
	//hide the top navigation panel
	document.getElementById('id_topnav').style.display = "none";
}

/*Handles filter movies onclick event to filter movies
*/
function movieFilterClick() {
	//load the navigation panel on demand
	makeAjaxGetRequest('moviezone_admin_main.php', 'cmd_show_top_nav', null, updateTopNav);
}
/*Handles movie form onclick event to show movie form
*/
function addNewMovie() {
	//load the movie form
	makeAjaxGetRequest('moviezone_admin_main.php', 'cmd_movie_form', null, updateContent);
}
/*Handles movie search page
*/
function searchPage() {
	//load the search page
	makeAjaxGetRequest('moviezone_admin_main.php', 'cmd_show_search_movie_page', null, updateContent);
}
/*Handles member search page
*/
function searchMemberPage() {
	//load the search page
	makeAjaxGetRequest('moviezone_admin_main.php', 'cmd_show_search_member_page', null, updateContent);
}
function searchMovie() {
	//load the search page
	// makeAjaxGetRequest('moviezone_admin_main.php', 'cmd_show_search_movie_page', null, updateContent);
	var movie_id=document.getElementsByName("edit_movie_id")[0].value;
	if(movie_id==""){
		alert('Please select a movie');
		return;
	}
	var params = '';
	params += '&movie_id=' + movie_id;
	
	makeAjaxGetRequest('moviezone_admin_main.php', 'cmd_movie_edit_form', params, updateContent);
}
function searchMember() {
	var member_id=document.getElementsByName("edit_member_id")[0].value;
	if(member_id==""){
		alert('Please select a member');
		return;
	}
	var params = '';
	params += '&member_id=' + member_id;
	
	makeAjaxGetRequest('moviezone_admin_main.php', 'cmd_member_edit_form', params, updateContent);
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