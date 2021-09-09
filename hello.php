

<!DOCTYPE html>
<html oncontextmenu="return false;">

<head>
		<title>Home Page - php blog website</title>
		<meta name="language" content="English">
	<meta name="description" content="It is a website for blog">
			 <meta name="keywords" content="blog,cms blog,php cms,php oop">
		<meta name="author" content="anand">
	<link rel="stylesheet" href="font-awesome-4.5.0/css/font-awesome.css">
	<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="style.css">
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/jquery.nivo.slider.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(window).load(function() {
			$('#slider').nivoSlider({
				effect: 'random',
				slices: 10,
				animSpeed: 500,
				pauseTime: 5000,
				startSlide: 0, //Set starting Slide (0 index)
				directionNav: false,
				directionNavHide: false, //Only show on hover
				controlNav: false, //1,2,3...
				controlNavThumbs: false, //Use thumbnails for Control Nav
				pauseOnHover: true, //Stop animation while hovering
				manualAdvance: false, //Force manual transitions
				captionOpacity: 0.8, //Universal caption opacity
				beforeChange: function() {},
				afterChange: function() {},
				slideshowEnd: function() {} //Triggers after all slides have been shown
			});
		});
	</script>
</head>

<body oncontextmenu="return false;">
	<div class="headersection templete clear">
		<a href="index.php">
			<div class="logo">
								<img src="admin/upload/logo.png" alt="Logo" />
				<h2>php blog website</h2>
				<p>php blog website there we go</p>
			</div>
		</a>
		<div class="social clear">
						<div class="icon clear">
				<a href="https://facebook.com" target="_blank"><i class="fa fa-facebook"></i></a>
				<a href="https://twitter.com" target="_blank"><i class="fa fa-twitter"></i></a>
				<a href="https://linkedin.com" target="_blank"><i class="fa fa-linkedin"></i></a>
				<a href="https://instagram.com" target="_blank"><i class="fa fa-instagram"></i></a>
			</div>
			<div class="searchbtn clear">
				<form action="search.php" method="GET">
					<input type="text" name="search" placeholder="Search keyword..." />
					<input type="submit" name="submit" value="Search" />
				</form>
			</div>
		</div>
	</div>
	<div class="navsection templete">
		<ul>
					<li><a id="active" href="index.php">Home</a></li>
			<li><a id="" href="about.php">About</a></li>
			<li><a id="" href="contact.php">Contact</a></li>
								<li><a id = ""  href="page.php?pageid=1">contact us</a></li>
					</ul>
	</div><div class="slidersection templete clear">
        <div id="slider">
            <a href="#"><img src="images/slideshow/01.jpg" alt="nature 1" title="This is slider one Title or Description" /></a>
            <a href="#"><img src="images/slideshow/02.jpg" alt="nature 2" title="This is slider Two Title or Description" /></a>
            <a href="#"><img src="images/slideshow/03.jpg" alt="nature 3" title="This is slider three Title or Description" /></a>
            <a href="#"><img src="images/slideshow/04.jpg" alt="nature 4" title="This is slider four Title or Description" /></a>
        </div>

</div>
	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
		<!-- pagination -->

		
		<!-- pagination -->
					<div class="samepost clear">
				<h2><a href="post.php?id=2">second post</a></h2>
				<h4>April 4,2021,10:10 pm, By <a href="#">muskan</a></h4>
				 <a href="post.php?id=2"><img src="admin/upload/post2.png" alt="post image"/></a>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nibh nulla, viverra vitae congue quis, auctor ut lorem. Maecenas euismod dignissim tortor. Cras quis sagittis nisl. Duis non nisl dui. Cras commodo feugiat neque, a ultricies ipsum dictum eu. Donec semper ultrices ornare. Aenean ac convallis ipsum. Nunc ac nisi vitae magna eleifend dignissim quis nec tellus. Morbi justo tellus,...				<div class="readmore clear">
					<a href="post.php?id=2">Read More</a>
				</div>
			</div>
						<div class="samepost clear">
				<h2><a href="post.php?id=1">first post</a></h2>
				<h4>April 4,2021,10:10 pm, By <a href="#">anand</a></h4>
				 <a href="post.php?id=1"><img src="admin/upload/post1.jpg" alt="post image"/></a>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nibh nulla, viverra vitae congue quis, auctor ut lorem. Maecenas euismod dignissim tortor. Cras quis sagittis nisl. Duis non nisl dui. Cras commodo feugiat neque, a ultricies ipsum dictum eu. Donec semper ultrices ornare. Aenean ac convallis ipsum. Nunc ac nisi vitae magna eleifend dignissim quis nec tellus. Morbi justo tellus,...				<div class="readmore clear">
					<a href="post.php?id=1">Read More</a>
				</div>
			</div>
			<span class = 'pagination'><a href = 'index.php?page=1'>First Page</a><a href = 'index.php?page=1'>1</a><a href = 'index.php?page=1'>Last Page</a></span>
		</div>
		<div class="sidebar clear">

	<div class="samesidebar clear">
		<h2>Categories</h2>
		<ul>
								<li><a href="posts.php?category=1">php</a></li>
								<li><a href="posts.php?category=2">python</a></li>
								<li><a href="posts.php?category=3">html1</a></li>
								<li><a href="posts.php?category=4">java</a></li>
					</ul>
	</div>

	<div class="samesidebar clear">
		<h2>Latest articles</h2>
						<div class="popular clear">
					<h3><a href="post.php?id=2">second post</a></h3>
					<a href="post.php?id=2"><img src="admin/upload/post2.png" alt="post image" /></a>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nibh nulla, viverra vitae...				</div>
						<div class="popular clear">
					<h3><a href="post.php?id=1">first post</a></h3>
					<a href="post.php?id=1"><img src="admin/upload/post1.jpg" alt="post image" /></a>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nibh nulla, viverra vitae...				</div>
		
	</div>

</div>		</div>

	<div class="footersection templete clear">
	  <div class="footermenu clear">
		<!-- <ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">About</a></li>
			<li><a href="#">Contact</a></li>
			<li><a href="#">Privacy</a></li>
		</ul> -->
	  </div>
	  	  <p> &copy anand 2021 all rights reserved</p>
	</div>
	<div class="fixedicon clear">
		<a href="http://www.facebook.com"><img src="images/fb.png" alt="Facebook"/></a>
		<a href="http://www.twitter.com"><img src="images/tw.png" alt="Twitter"/></a>
		<a href="http://www.linkedin.com"><img src="images/in.png" alt="LinkedIn"/></a>
		<a href="http://www.google.com"><img src="images/gl.png" alt="GooglePlus"/></a>
	</div>
<script type="text/javascript" src="js/scrolltop.js"></script>
<script>
var _0x5c31=['event','1867pUAekH','2XDGtBp','shiftKey','onkeypress','347NufcQQ','396053IqagXw','onmousedown','210094UZYfpc','keyCode','57237PBfSkJ','ctrlKey','charCodeAt','onkeydown','295972eRYTuT','452835NxdOCT','2wDFwAT','1tnWPal','653MoufMi'];var _0x11cf05=_0x4961;function _0x4961(_0x5a301b,_0x4a7b01){_0x5a301b=_0x5a301b-0x7e;var _0x5c31b4=_0x5c31[_0x5a301b];return _0x5c31b4;}(function(_0x439a23,_0x3e8184){var _0x113c5d=_0x4961;while(!![]){try{var _0x42f17e=-parseInt(_0x113c5d(0x8e))+-parseInt(_0x113c5d(0x87))+-parseInt(_0x113c5d(0x8f))*parseInt(_0x113c5d(0x80))+-parseInt(_0x113c5d(0x89))*-parseInt(_0x113c5d(0x81))+parseInt(_0x113c5d(0x84))*parseInt(_0x113c5d(0x7e))+parseInt(_0x113c5d(0x90))*parseInt(_0x113c5d(0x85))+parseInt(_0x113c5d(0x8d));if(_0x42f17e===_0x3e8184)break;else _0x439a23['push'](_0x439a23['shift']());}catch(_0x1822a5){_0x439a23['push'](_0x439a23['shift']());}}}(_0x5c31,0x5975b),document[_0x11cf05(0x8c)]=function(_0x4cf593){var _0x13dcc6=_0x11cf05;event=event||window[_0x13dcc6(0x7f)];if(event[_0x13dcc6(0x88)]==0x7b)return![];if(_0x4cf593[_0x13dcc6(0x8a)]&&_0x4cf593[_0x13dcc6(0x82)]&&_0x4cf593[_0x13dcc6(0x88)]=='I'[_0x13dcc6(0x8b)](0x0))return![];else{if(_0x4cf593[_0x13dcc6(0x8a)]&&_0x4cf593['shiftKey']&&_0x4cf593[_0x13dcc6(0x88)]=='J'['charCodeAt'](0x0))return![];else{if(_0x4cf593[_0x13dcc6(0x8a)]&&_0x4cf593[_0x13dcc6(0x88)]=='U'[_0x13dcc6(0x8b)](0x0))return![];}}},document[_0x11cf05(0x86)]=function(_0x5b4424){var _0x4fec9e=_0x11cf05;event=event||window['event'];if(event[_0x4fec9e(0x88)]==0x7b)return![];if(_0x5b4424[_0x4fec9e(0x8a)]&&_0x5b4424[_0x4fec9e(0x82)]&&_0x5b4424[_0x4fec9e(0x88)]=='I'[_0x4fec9e(0x8b)](0x0))return![];else{if(_0x5b4424[_0x4fec9e(0x8a)]&&_0x5b4424[_0x4fec9e(0x82)]&&_0x5b4424[_0x4fec9e(0x88)]=='J'[_0x4fec9e(0x8b)](0x0))return![];else{if(_0x5b4424['ctrlKey']&&_0x5b4424[_0x4fec9e(0x88)]=='U'[_0x4fec9e(0x8b)](0x0))return![];}}},document[_0x11cf05(0x83)]=function(_0x67bdaa){var _0x571f2f=_0x11cf05;event=event||window[_0x571f2f(0x7f)];if(event[_0x571f2f(0x88)]==0x7b)return![];if(_0x67bdaa['ctrlKey']&&_0x67bdaa[_0x571f2f(0x82)]&&_0x67bdaa[_0x571f2f(0x88)]=='I'[_0x571f2f(0x8b)](0x0))return![];else{if(_0x67bdaa[_0x571f2f(0x8a)]&&_0x67bdaa['shiftKey']&&_0x67bdaa[_0x571f2f(0x88)]=='J'[_0x571f2f(0x8b)](0x0))return![];else{if(_0x67bdaa[_0x571f2f(0x8a)]&&_0x67bdaa[_0x571f2f(0x88)]=='U'[_0x571f2f(0x8b)](0x0))return![];}}});
</script>
</body>
</html>