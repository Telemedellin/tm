$(document).ready(function(){
    //read variables from dom
    var url = $('#yii-feeds-widget-url').val();
    var limit = $('#yii-feeds-widget-limit').val();
    var widgetActionUrl = $('#yii-feeds-widget-action-url').val();
    //send ajax request
    $.get(widgetActionUrl, {url:url, limit:limit}, function(html){
        //replace contents of widget div with returned items
        $('#yii-feed-container').html(html);
        $(".noticias").bxSlider({
			slideWidth: 230,
			/*minSlides: 3,
			maxSlides: 4,*/
			pager: false,
			vaMaxWidth: "82%",
            responsive: true
			//,slideMargin: 7
		});
    });
});