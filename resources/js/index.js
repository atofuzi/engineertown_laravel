//トップページタイトル表示
var $top_title = $('.js-top-page-title');
var $top_menu = $('.js-menu-list');

$.when(
	$top_title.fadeIn(2000)
).done(function(){ 
    $top_menu.fadeIn(500);
});