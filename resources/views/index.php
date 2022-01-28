<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Perma Store</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
	<meta name="description" content="Store information permanently (on the block chain)">
	<style>
		* {
			padding: 0;
			margin: 0;
		}
		html,body{
			height: 100%;
			font-family: Sans-serif;
		}
		#b{
			position:relative;
			min-height: 100%;
			border-collapse: collapse;
		}
		#bg {
			position: fixed;
			background: #fff none repeat scroll 0 0;
			overflow: hidden;
			height: 100%;
			width: 100%;
		}
		#bgimg {
			opacity: 1;
			background-position: center center;
			background-size: cover;
			height: 100%;
			width: 100%;
		}
		a, a:hover, a:visited {
			color: grey;
			text-decoration: none;
		}
		a.link, a.link:hover, a.link:visited {
			color: blue;
			text-decoration: underline;
		}
		.title {
			position: absolute;
			margin: 0 auto;
			padding: 50px;
			top: 50px;
			left: 0;
			width: 100%;
			font-size: 100px;
			background: -webkit-linear-gradient(#00616B, #F7EBE4);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			text-shadow: 2px 2px 8px #000000;
		}
		@media screen and (max-width: 992px) {
			.title {
				top: 0px;
				padding: 20px;
				font-size: 50px;
			}
		}
		.subtitle {
			position: absolute;
			padding: 50px;
			top: 450px;
			left: 0;
			width: 100%;
			font-size: 50px;
			text-align: center;
		}
		@media screen and (max-width: 992px) {
			.subtitle {
				top: 350px;
				padding: 20px;
				font-size: 30px;
			}
		}
		.footer {
			position: absolute;
			bottom: 0;
			right: 0;
			height: 50px;
			width: 250px;
			color: grey;
			font-size: 20px;
		}
	</style>
</head>
<body>

	<div id="b">
		<div id="bg">
			<div id="bgimg" style="background-image:url(https://source.unsplash.com/o4xVOHa3FXw/1600x900);"></div>
		</div>
		<h1 class="title">Can you prove timely ownership of information?</h1>
		<h3 class="subtitle">
			Store your information on the block chain.<br>
			Website coming soon!
			Visit the <a href="/playground" class="link">Playground</a></h3>
		<div class="footer">
			Photo by <a href="https://unsplash.com/@bobzepplin" target="_blank" rel="noreferrer noopener">William Christen</a>
		</div>
  
	</div>

</body>
</html>
