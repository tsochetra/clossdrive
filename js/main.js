var wh = $(window).height() -300;
var tp = wh /6;
var bt = wh /3.5;
var wheel = wh - 500;
var whe = wheel / 2;
if(whe <= 0) {
var whe = 50;
}
if(tp <= 0) {
var tp = 0;
}
if(bt <= 0) {
var bt = 0;
}
$(".text").css({
	'height' : wh + 'px'
});
$(".out-wheel").css({
	'margin-top' : whe + 'px'
});
$(".title").css({
	'margin-top' : tp + 'px'
});
$(".button").css({
	'margin-top' : bt + 'px'
});

$(window).scroll(function() {
	var ws = $(this).scrollTop();
	var ss = $(".page-2").height() + wh;
	if(ws > ss) {
		$(".map-doc-1").fadeIn(250,function() {
			$(".map-doc-2").fadeIn(250, function() {
				$(".map-doc-3").fadeIn(250, function() {
					$(".map-doc-4").fadeIn(250);
				});
			});
		});
		
	} else {
		$(".map-doc-1").fadeOut();
		$(".map-doc-2").fadeOut();
		$(".map-doc-3").fadeOut();
		$(".map-doc-4").fadeOut();
	}
	if(ws > wh) {
		$(".wheel-arrow-1").css({
			'background-position' : '-40% -150%'
		});
		$(".wheel-arrow-2").css({
			'background-position' : '140% -40%'
		});
		$(".wheel-arrow-3").css({
			'background-position' : '-75% 230%'
		});
		$(".wheel-arrow-4").css({
			'background-position' : '165% 175%'
		});
		$(".wheel-cloud-1").css({
			'opacity' : '1'
		});
		$(".wheel-cloud-2").css({
			'opacity' : '1'
		});
		$(".wheel-cloud-5").css({
			'top' : '110px'
		});
		$(".wheel-ipad").css({
			'background-position' : '107% 236%'
		});
		$(".wheel-iphone").css({
			'background-position' : '-97% -17%'
		});
	} else {
		$(".wheel-arrow-1").css({
			'background-position' : '-330% -330%'
		});
		$(".wheel-arrow-2").css({
			'background-position' : '300% -250%'
		});
		$(".wheel-arrow-3").css({
			'background-position' : '-370% 500%'
		});
		$(".wheel-arrow-4").css({
			'background-position' : '600% 300%'
		});
		$(".wheel-cloud-1").css({
			'opacity' : '0'
		});
		$(".wheel-cloud-2").css({
			'opacity' : '0'
		});
		$(".wheel-cloud-5").css({
			'top' : '135px'
		});
		$(".wheel-ipad").css({
			'background-position' : '-540% 236%'
		});
		$(".wheel-iphone").css({
			'background-position' : '440% -17%'
		});
	}
});

