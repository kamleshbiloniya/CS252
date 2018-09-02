<!doctype html>
<html >

<head>

<title>startup</title>
<link rel="stylesheet" type="text/css" href="main.css" />
<script src="rulebook.js"></script>

</head>

<body>


	<header id = "top_bar">
	
	
	
	</header>
	
	<nav id="navi">
		
	</nav>
	
	<div id = "imp_div">
	
	<?php
	
	$cats = 4;
	if($cats >0){
		echo "<div id='cats'>"; 
		
  		for( ;$cats>0;$cats--)
		{
		
			echo "<article >";
			echo "<img src='cat".$cats.".jpg'>";
			echo "</article>";
		}
		
		echo "</div>";
	}
	?>
	<div id="dogs">
		<article >
			<img src="dog1.jpg" >
		</article>
		<article>
			<img src="dog2.jpg" >
		</article>
		<article>
			<img src="dog3.jpg" >
		</article>
		<article >
			<img src="dog4.jpg" >
		</article>	
	</div>
	
	<div id="cars">
		<article >
			<img src="car1.jpg" >
		</article>
		<article>
			<img src="car2.jpg" >
		</article>
		<article>
			<img src="car3.jpg" >
		</article>
		<article >
			<img src="car4.jpg" >
		</article>	
	</div>
	
	<div id="trucks">
		<article >
			<img src="truck1.jpg" >
		</article>
		<article>
			<img src="truck2.jpg" >
		</article>
		<article>
			<img src="truck3.jpg" >
		</article>
		<article >
			<img src="truck4.jpg" >
		</article>	
	</div>
	</div>
	
	
	

</body>

</html>
