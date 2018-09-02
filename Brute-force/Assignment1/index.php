<!doctype html>
<html >

<head>

<title>BruteForce</title>
<link rel="stylesheet" type="text/css" href="main.css" />
<script src="rulebook.js"></script>

</head>

<body>


	<header id = "top_bar">
	
	<h1> CS252 Assignment 1 : Team BruteForce </h1>
	
	</header>
	
	<nav id="navi">
		
	</nav>
	
	<div id = "imp_div">
	
	<?php
	
	$f = fopen("input.txt", "r") or die("Unable to open file!");
	$dogs = (int)fread($f,1);
	$cats = (int)fread($f,1);
	$cars = (int)fread($f,1);
	$trucks = (int)fread($f,1);
    fclose($f);
    
    
	
	if($dogs >0){
		echo "<div id='dogs'>"; 
		
  		for( ;$dogs>0;$dogs--)
		{
		
			echo "<article >";
			echo "<img src='images/dog".$dogs.".jpg'>";
			echo "</article>";
		}
		
		echo "</div>";
	}
	
	if($cats >0){
		echo "<div id='cats'>"; 
		
  		for( ;$cats>0;$cats--)
		{
		
			echo "<article >";
			echo "<img src='images/cat".$cats.".jpg'>";
			echo "</article>";
		}
		
		echo "</div>";
	}
	
	
	if($cars >0){
		echo "<div id='cars'>"; 
		
  		for( ;$cars>0;$cars--)
		{
		
			echo "<article >";
			echo "<img src='images/car".$cars.".jpg'>";
			echo "</article>";
		}
		
		echo "</div>";
	}
	
	if($trucks >0){
		echo "<div id='trucks'>"; 
		
  		for( ;$trucks>0;$trucks--)
		{
		
			echo "<article >";
			echo "<img src='images/truck".$trucks.".jpg'>";
			echo "</article>";
		}
		
		echo "</div>";
	}
	
	
	?>
	
	</div>
	
	
	

</body>
</html>
