<!DOCTYPE html>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
 <script src="myscript.js"></script>
</head>

<body>

<h2>Show Database</h2>

								<!-- Search form -->
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

</fieldset >
</form>

<br><br>


                    <!-- Employees by department form -->
<form method="post" name="myform" action="" onsubmit="return validationForm()" >
<fieldset >
<input type="submit" name="submit2" value="show number of employees by departments">
</fieldset >
</form>



<br><br>
<form method="post" name="myform" action="" onsubmit="return validationForm()" >
<fieldset>
Department:<input type="text" name="dept" maxlength="20" id="myInput1">

<br><br>
<input type="submit" name="submit3" value="show gender ratio">
<input type="reset" value="Clear">

</fieldset >
</form>

                       <!-- PHP SCRIPT STARTS HERE -->

<?php

$servername = "localhost";
$username = "cs252";
$password = "cs252";
$database = "employees";
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
	
}


if(isset($_POST['submit2'])){


	echo "Largest departments :<br>";

	$q = "select count(*) as c, d.dept_name as k from current_dept_emp as cur join departments as d on cur.dept_no = d.dept_no group by cur.dept_no order by c desc;";

	$r = $conn->query($q);

	if ($r->num_rows > 0) {
    // output data of each row
	    while($row = $r->fetch_assoc()) {
	        $c =  $row["c"];
	        $dname = $row["k"];
	        
	        echo "number of employees in ".$dname." are : ".$c . "<br>" ;
	    }
	} 

	else {
	    echo "0 results";
	}	

}

if(isset($_POST['submit3'])){

	$d = $_POST['dept'];


	echo $d ."<br>";

	$q = "select count(*) as co, e.gender as g from employees as e join current_dept_emp as c on c.emp_no = e.emp_no where c.dept_no = '".$d."' group by e.gender;";

	//echo $q;

	$res = $conn->query($q);
	
	//$m = 1;
	//$f = 1;

	if ($res->num_rows > 0) {
    // output data of each row
	    while($row = $res->fetch_assoc()) {
	        $c =  $row["co"];
	        $gender = $row["g"];
	        
	        echo $c." ".$gender."<br>";
	        // echo $gender;
	        
	        if ( $gender == 'M'){
	        	$m = $c;
	        	// echo "Hello".$m;
	        }
	        else{
	        	$f = $c;
	        }	        
	    }
	} 

	else {
	    echo "0 results";
	}	

	echo "Female : Male :: ".$f." : ".$m."<br>";
	echo "Gender Ratio = ";
	echo ($f/$m)*1000;
	echo "<br>";

}

$conn->close();

?>

</body>
</html>
