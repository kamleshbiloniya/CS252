 <!DOCTYPE html>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
 <script src="myscript.js"></script>
<a href="video.php">link</a>
<a href = "webcam.php">webcam page</a>
</head>
<body>
<h2>Show Database</h2>
<form method="post" name="myform" action="" onsubmit="return validationForm()" >
  <fieldset >
ID:<input type="number" name="id" maxlength="5" id="myInput1">

<!-- <span class="error" id="idid">*</span> -->
<br><br>
Last name:<input type="text" name="name" maxlength="20" id="myInput1">
<br><br>
Department:<input type="text" name="dept" maxlength="20" id="myInput1">
<!-- <span class="error" id="nameid">*</span> -->
<br><br>

<input type="submit" name="submit" value="show">
<input type="reset" value="Clear">
<br><br>
<form method="post" name="myform" action="" onsubmit="return validationForm()" >
Department:<input type="text" name="dept" maxlength="20" id="myInput1">
<!-- <span class="error" id="nameid">*</span> -->
<br><br>
<input type="submit" name="submit2" value="show gender ratio">
<input type="reset" value="Clear">
</form>
</fieldset >
</form>
<?php
$servername = "localhost";
$username = "cs252";
$password = "cs252";
$database = "employe";

// Create connection
$conn = new mysqli($servername, $username, $password , $database);

// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
else
{
	echo "connected successfuly";
	echo "</br>";
}
if(isset($_POST["submit"])){
	$q = "select * from emp where";
	$id = $_POST['id'];
	$name = $_POST['name'];
	$dept = $_POST['dept'];
	if($id > 0){
		$id = $_POST['id'];
		$q = $q . " id = ".$id;
		if($name != "" || $dept != "")
			$q = $q . " AND";
	}
	if($name !="" ){
		$name = $_POST['name'];
		$q = $q . " lname = '".$name . "'";

		if($dept != "")
			$q = $q . " AND";
	}
	if($dept !=""){
		$dept = $_POST['dept'];
		$q = $q . " dept = '".$dept."'";
	}
	$q = $q . ";";
	//echo $q;
	$result = $conn->query($q);

	if ($result->num_rows > 0) {
    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        echo "Id: " . $row["id"]. " first Name: " . $row["fname"]. "; Last name:" . $row["lname"]. "<br>";
	    }
	} else {
	    echo "0 results";
	}
	$conn->close();

}
if(isset($_POST['submit2'])){
	$dept = $_POST['dept'];
	$qmale = "select count(*) as m from emp where dept = '".$dept."' AND gender = 'male';";
	$qfemale = "select count(*) as f from emp where dept = '".$dept."' AND gender = 'female';";
	echo " gender ratio = ";
	$resultmale = $conn->query($qmale);
	$resultfemale = $conn->query($qfemale);
	if ($resultmale->num_rows > 0) {
    // output data of each row
	    while($row = $resultmale->fetch_assoc()) {
	        $num_m =  $row["m"];
	        // echo $num_m;
	    }
	} else {
	    echo "0 results";
	}
	if ($resultfemale->num_rows > 0) {
    // output data of each row
	    while($row = $resultfemale->fetch_assoc()) {
	        $num_f= $row["f"];
	        // echo $num_f;

	    }
	} else {
	    echo "0 results";
	}
	echo $num_f;
	echo " : ";
	echo $num_m;
	echo "<br>";
	echo ($num_f / $num_m)*1000;



}



?>
</body>
</html>
