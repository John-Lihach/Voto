<html>

<head>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<style>
		#contactLink{
			border-left: 5px solid white;
			font-weight: bold;
		}
		#contentContainer{
			display: flex;
			flex-direction: column;
			min-height: calc(100% - 5em);
		}
		#contactHeader{
			text-align: center;
			color: white;
			font-size: 2em;
		}
		#contactOptionsContainer{
			display: flex;
			flex-direction: row;
			justify-content: space-around;
			height: 100%;
		}
		.contactOption{
			background-color: darkgrey;
			width: 20em;
			height: 35em;
			padding: .5em;
			margin: 1em;
			display: flex;
			flex-direction: column;
			align-items: center;
			transition: .3s;
		}
		.contactOption:hover{
			box-shadow: 0 0 20px rgba(0,0,0,.25);
		}
		.contactTextContainer{
			height: 50%;
			font-weight: bold;
			color: white;
			text-align: center;
		}
		.contactIconContainer{
			height: 50%;
		}
		.contactIcon{
			font-size: 15em;
		}
		@media only screen and (max-width: 60em){
			.contactOption{
				width: 30%;
			}
			.contactIcon{
				font-size: 10em;
				margin-top: .25em;
			}
		}
		@media only screen and (max-width: 40em){
			#contactOptionsContainer{
				flex-direction: column;
				align-items: center;
			}
			.contactOption{
				width: 80%;
			}
			.contactIcon{
				font-size: 15em;
				margin-top: 0;
			}
		}
	</style>
</head>

<body>
	<?php include('header.php')?>
	
	<div id="contentContainer">
		<div id="contactHeader">
			<h1> Contact Us </h1>
		</div>
		
		<div id="contactOptionsContainer">
			<div class="contactOption">
				<div class="contactTextContainer">
					<h2>Phone</h2>
					</br>
					<p><i>For Business Inquires</i></p>
					<p>703-123-4567</p>
					</br>
					<p><i>For Customer Service</i></p>
					<p>703-435-1234</p>
				</div>
				<div class="contactIconContainer">
					<i class="material-icons contactIcon">contact_phone</i>
				</div>
			</div>
			<div class="contactOption">
				<div class="contactTextContainer">
					<h2>Email</h2>
					</br>
					<p><i>For Business Inquires</i></p>
					<p>votoBusiness@gmail.com</p>
					</br>
					<p><i>For Customer Service</i></p>
					<p>votoHelp@gmail.com</p>
				</div>
				<div class="contactIconContainer">
					<i class="material-icons contactIcon">comment</i>
				</div>
			</div>
			<div class="contactOption">
				<div class="contactTextContainer">
					<h2>Mail</h2>
					</br>
					<p><i>For Business Inquires</i></p>
					<p>1234 Fairfax Dr. Arlington, VA</p>
					</br>
					<p><i>Our P.O. Box</i></p>
					<p>PO Box 123 Henry Rd, Arlington, VA</p>
				</div>
				<div class="contactIconContainer">
					<i class="material-icons contactIcon">mail</i>
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