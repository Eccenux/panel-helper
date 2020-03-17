/* global DrawHistoryValue, selected_profile_id, search_profiles */

//
// Fill options of select/combobox
//
var profile_select = document.querySelector('#search [name=profil]');
search_profiles.forEach(function(profile){
	var value = profile.id;
	var selected = (profile.id == selected_profile_id);
	var short = {
		sex : DrawHistoryValue.firstLetter(profile.sex),
		region : DrawHistoryValue.shortWords(profile.region),
		age : DrawHistoryValue.range(profile.age_min, profile.age_max),
		education : DrawHistoryValue.firstLetter(profile.education_long),
	};
	var text = `(${profile.id}) [${profile.group_name}] ${short.sex}, ${short.region}, ${short.age}, ${short.education}`;
	var nel = document.createElement('option');
	nel.setAttribute('value', value);
	if (selected) {
		nel.setAttribute('selected', 'selected');
	}
	nel.innerHTML = text;
	profile_select.appendChild(nel);
});

//
// Select profile.
//
$(profile_select).change(function() {
	var baseUrl = location.href.replace(/&profil=[0-9]*/, '');
	location.href = `${baseUrl}&profil=${this.value}`;
});

//
// Next/previous
//
(function(){
	if (search_profiles.length < 2) {
		return;
	}
	var first = search_profiles[0];
	var last = search_profiles[search_profiles.length - 1];

	function getUrlData() {
		var current = 0;
		var baseUrl = location.href.replace(/&profil=([0-9]*)/, function(a, num){
			current = parseInt(num, 10);
			return '';
		});
		return {baseUrl, current};
	}

	/**/
	$('.profil-prev').click(function(event) {
		event.preventDefault();
		var u = getUrlData();
		if (u.current > 0 && u.current != first.id) {
			u.current--;
			console.log(location.href, `${u.baseUrl}&profil=${u.current}`);
			location.href = `${u.baseUrl}&profil=${u.current}`;
		}
	});
	$('.profil-next').click(function(event) {
		event.preventDefault();
		var u = getUrlData();
		if (u.current != last.id) {
			u.current++;
			location.href = `${u.baseUrl}&profil=${u.current}`;
		}
	});
	/**/
})();
