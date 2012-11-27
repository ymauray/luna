jQuery(document).ready(function($j) {
	$j(".tab_content_login").hide();
	$j("ul.tabs_login li:first").addClass("active_login").show();
	$j(".tab_content_login:first").show();
	$j("ul.tabs_login li").click(function() {
		$j("ul.tabs_login li").removeClass("active_login");
		$j(this).addClass("active_login");
		$j(".tab_content_login").hide();
		var activeTab = $j(this).find("a").attr("href");
		if ($j.browser.msie) {$j(activeTab).show();}
		else {$j(activeTab).show();}
		return false;
	});
});
