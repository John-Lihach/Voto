<html>

<head>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<style>
		#aboutLink{
			border-left: 5px solid white;
			font-weight: bold;
		}
		#contentContainer{
			position: relative;
			display: flex;
			flex-direction: column;
			min-height: calc(100% - 5em);
		}
		#aboutHeader{
			text-align: center;
			color: white;
			font-size: 2em;
		}
		#aboutContent{
			display: flex;
			flex-direction: column;
			justify-content: space-around;
			align-items: center;
		}
		#aboutContent h2{
			color: rgb(75,75,75);
		}
		
		.container{
			background-color: darkgrey;
			padding: 1em;
			margin: .5em;
			box-sizing: border-box;
			width: 100%;
			height: 25%;
			display: flex;
			flex-direction: row;
			align-items: center;
			justify-content: flex-start;
			font-size: 1.2em;
			transition: .3s;
		}
		.container:hover{
			box-shadow: 0 0 20px rgba(0,0,0,.25);
		}
		.specialIcon{
			font-size: 10em;
		}
		@media only screen and (max-width: 60em){
			.specialIcon{
				font-size: 7em;
			}
		}
	</style>
</head>

<body>
	<?php include('header.php')?>
	
	<div id="contentContainer">
		<div id="aboutHeader">
			<h1> About Us </h1>
		</div>
		<div id="aboutContent">
			<div id="missionContainer" class="container">
				<i class="material-icons specialIcon" style="color: gold">star</i>
				<div class="column">
					<h2>Our Mission</h2>
					<p>Our Mission is to bring about unity by bringing the community together. Voto is all about sharing creations, laughs, and awes, all on one bulletin board.</p>
				</div>
			</div>
			<div id="whereContainer" class="container">
				<i class="material-icons specialIcon" style="color: darkblue">business</i>
				<div class="column">
					<h2>Where We Work</h2>
					<p>Arlington County, Virginia is the home of Voto. Here our developers have flourished, both in and out of the workplace. Here it's all about the best possible way to Live, Work, and Play.</p>
				</div>
			</div>
			<div id="howContainer" class="container">
				<i class="material-icons specialIcon" style="color: green">extension</i>
				<div class="column">
					<h2>How We Do It</h2>
					<p>Through expert developers, designers, and marketers, we work hard to deliver a product that takes notice of the consumer and impresses the innovator. All our products are created with the thought and care that is sure to benefit the customer.</p>
				</div>
			</div>
			<div id="futureContainer" class="container">
				<i class="material-icons specialIcon" style="color: red">timelapse</i>
				<div class="column">
					<h2>What's Next?</h2>
					<p>The future is bright, and we hope to be on it's frontier. By supporting in-house and world-wide innovation, we aim to bring about a new age of technological process that will keep people connected and prosperous.</p>
				</div>
			</div>
		</div>	
	</div>
	
	<script src="headerScript.js"></script>
	
	<script>
		document.body.onload = function(){
			setMenuSize();
			checkForToken();
		}
	</script>
	
</body>

</html>