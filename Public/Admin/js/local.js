$(function(){
	if (window.localStorage) {
		if (localStorage.nowItem) {
			$("#side-menu li.nav-item").eq(localStorage.nowItem).find("ul.nav-second-level").addClass("collapse in");
		}

		$("#side-menu li.nav-item").click(function(){
			localStorage.nowItem = $(this).index();

		})
	}
	
})