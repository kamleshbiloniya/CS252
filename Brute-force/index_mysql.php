<!DOCTYPE html>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
 <script src="myscript.js"></script>
</head>

<body>

<h2>Forms :</h2>

								<!-- Search form -->
<form method="post" name="myform" action="" onsubmit="return validationForm()" >
  <fieldset >
ID:<input type="number" name="id" maxlength="5" id="myInput1">

<br><br>

<input type="submit" name="submit0" value="Search">
<input type="reset" value="Clear">
<br>

</fieldset >
</form>

				<!-- Search form with Last Name and Dept -->

<form method="post" name="myform" action="" onsubmit="return validationForm()" >
  <fieldset >
Last name:<input type="text" name="name" maxlength="20" id="myInput1">
<br><br>
Department: <select name="dept">
  <option value="d000">Choose Department</option>
  <option value="d001">Marketing</option>
  <option value="d002">Finance</option>
  <option value="d003">Human Resources</option>
  <option value="d004">Production</option>
  <option value="d005">Development</option>
  <option value="d006">Quality Management</option>
  <option value="d007">Sales</option>
  <option value="d008">Research</option>
  <option value="d009">Customer Service</option>
 </select> 
<br><br>
<input type="submit" name="submit1" value="Search">
<input type="reset" value="Clear">


</fieldset >
</form>







                    <!-- Employees count by department form -->
<form method="post" name="myform" action="" onsubmit="return validationForm()" >
<fieldset >
<input type="submit" name="submit2" value="Employees count by departments">
</fieldset >
</form>


					<!-- Gender Ratio per department -->
<form method="post" name="myform" action="" onsubmit="return validationForm()" >
<fieldset>
Department:<input type="text" name="dept" maxlength="20" id="myInput1">

<br><br>
<input type="submit" name="submit3" value="show gender ratio">
<input type="reset" value="Clear">

</fieldset >
</form>


                    <!-- Employee's Tenure by Department -->

<form method="post" name="myform" action="" onsubmit="return validationForm()" >
<fieldset>
Department:<input type="text" name="dept" maxlength="20" id="myInput1">

<br><br>
<input type="submit" name="submit4" value="Show Tenure">
<input type="reset" value="Clear">

</fieldset >
</form>

			<!-- Employees gender pay-ratio per department  -->

<form method="post" name="myform" action="" onsubmit="return validationForm()" >
<fieldset>
Department:
 <select name="dept">
  <option value="d001">Marketing</option>
  <option value="d002">Finance</option>
  <option value="d003">Human Resources</option>
  <option value="d004">Production</option>
  <option value="d005">Development</option>
  <option value="d006">Quality Management</option>
  <option value="d007">Sales</option>
  <option value="d008">Research</option>
  <option value="d009">Customer Service</option>
 </select> 

<br><br>
<input type="submit" name="submit5" value="Show Gender Pay-Ratio">
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


if(isset($_POST["submit0"])){

	$id = $_POST['id'];

	$q = 'select emp_no, first_name as fname, last_name as lname , gender from employees where emp_no = '.$id.';';
	
	// echo $q;
	
	$result = $conn->query($q);
	if ($result->num_rows > 0) {
    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        echo "Id: " . $row["emp_no"]. "<br>First Name: " . $row["fname"]. "<br>Last Name:" . $row["lname"]. "<br>Sex: ".$row["gender"]."<br>";
	    }
	} else {
	    echo "Wrong Employee ID\n";
	}
	// $conn->close();
}

if(isset($_POST["submit1"])){

	$q = 'select emp_no, first_name as fname, last_name as lname , gender from employees where';
	
	$name = $_POST['name'];
	$dept = $_POST['dept'];

	$q = $q.' last_name = "'.$name.'"';

	if($dept == "d000"){
		$q = $q.";";
	}

	else{
		$q = 'select e.emp_no, e.first_name as fname, e.last_name as lname , e.gender from employees as e , current_dept_emp as c where c.emp_no = e.emp_no and e.last_name = "'.$name.'" and c.dept_no = "'.$dept.'";';
	}
	
	
	
	$result = $conn->query($q);
	if ($result->num_rows > 0) {
    // output data of each row
	    while($row = $result->fetch_assoc()) {
	       echo "Id: " . $row["emp_no"]. "<br>First Name: " . $row["fname"]. "<br>Last Name:" . $row["lname"]. "<br>Sex: ".$row["gender"]."<br>";
	   }
	}
	 else {
	    echo "0 results";
	}
	// $conn->close();
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
	        
	        echo "Employees in ".$dname." are : ".$c . "<br>" ;
	    }
	} 

	else {
	    echo "0 results";
	}	

}


if(isset($_POST['submit3'])){

	$d = $_POST['dept'];
	
	$d = preg_replace("/^ */", '', $d);
	$d = preg_replace("/ *$/", '', $d);

	$pattern = "/[dD]00[1-9]/";
	// echo $d."<br>";

	if(!preg_match($pattern, $d))
	{	
	
		$q = 'select dept_no as d from departments where dept_name = "'.$d.'" ;';
		// echo $q;
		$r = $conn->query($q);

		if ($r->num_rows > 0) {
			// echo "hey";
		    // output data of each row
		    while($row = $r->fetch_assoc()) {
		        $d =  $row["d"];
		    }

		} 

		else {
		    echo "Please enter correct department name <br>";
		}	

	}
	// echo $d;
	if(preg_match($pattern, $d))
		{	
			echo "match found<br>";
		}

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

if(isset($_POST['submit4'])){

	$d = $_POST['dept'];
	$d = preg_replace("/^ */", '', $d);
	$d = preg_replace("/ *$/", '', $d);

	$pattern = "/[dD]00[1-9]/";
	// echo $d."<br>";

	if(!preg_match($pattern, $d))
	{	
	
		$q = 'select dept_no as d from departments where dept_name = "'.$d.'" ;';
		// echo $q;
		$r = $conn->query($q);

		if ($r->num_rows > 0) {
			// echo "hey";
		    // output data of each row
		    while($row = $r->fetch_assoc()) {
		        $d =  $row["d"];
		    }

		} 

		else {
		    echo "Please enter correct department name <br>";
		}	

	}
	// echo $d;
	if(preg_match($pattern, $d))
		{	
			echo "match found<br>";
		}

	// echo $d;

	$q = 'select d.emp_no as emp, e.hire_date as f, d.to_date as t,DATEDIFF(d.to_date,e.hire_date) as days from employees as e , current_dept_emp as d where e.emp_no = d.emp_no and d.dept_no = "'.$d.'" order by DATEDIFF(d.to_date,e.hire_date) DESC;';

	// echo $q;

	$res = $conn->query($q);
	
	if ($res->num_rows > 0) {
    // output data of each row
	    while($row = $res->fetch_assoc()) {
	    	$emp = $row["emp"];
	        $from =  $row["f"];
	        $to = $row["t"];
	        
	        
	        echo $emp." ";
	        echo "from ".$from;

	        if ( preg_match("/9999-01-01/", $to)){
	        	echo "<br>";
	        }
	        else{
	        	echo " to ".$to."<br>";
	        }	        
	    }
	} 

	else {
	    echo "0 results";
	}	


}


if(isset($_POST['submit5'])){

	$d = $_POST['dept'];
	
	// echo $d;

	if(!preg_match("/d00[1-9]/", $d)){
		echo "HTML Form tempered";
	}
	
	$q = 'select m.title, m.cout as mavg , f.cout as favg from (select e.gender as gender, t.title as title , avg(s.salary) as cout from current_dept_emp as c , employees as e, salaries as s, titles as t where c.dept_no = "'.$d.'" and e.gender = "M" and c.emp_no = e.emp_no and e.emp_no = s.emp_no and s.emp_no = t.emp_no group by t.title ) as m left join (select e.gender as gender, t.title as title , avg(s.salary) as cout from current_dept_emp as c , employees as e, salaries as s, titles as t where c.dept_no = "'.$d.'" and e.gender = "F" and c.emp_no = e.emp_no and e.emp_no = s.emp_no and s.emp_no = t.emp_no group by t.title ) as f on m.title = f.title union select m.title, m.cout as mavg, f.cout as favg from (select e.gender as gender, t.title as title , avg(s.salary) as cout from current_dept_emp as c , employees as e, salaries as s, titles as t where c.dept_no = "'.$d.'" and e.gender = "M" and c.emp_no = e.emp_no and e.emp_no = s.emp_no and s.emp_no = t.emp_no group by t.title ) as m right join (select e.gender as gender, t.title as title , avg(s.salary) as cout from current_dept_emp as c , employees as e, salaries as s, titles as t where c.dept_no = "'.$d.'" and e.gender = "F" and c.emp_no = e.emp_no and e.emp_no = s.emp_no and s.emp_no = t.emp_no group by t.title ) as f on m.title = f.title ;';

	// echo $q;

	$res = $conn->query($q);
	
	if ($res->num_rows > 0) { 
   // output data of each row
	    while($row = $res->fetch_assoc()) {
	        $t =  $row["title"];
	        $m = $row["mavg"];
	        $f = $row["favg"];

	        if(is_null($f)){
	        	$f = 0;
	        }

	        if(is_null($m)){
	        	$m = 0;
	        }
	        	
	        echo $t." ".$m." : ".$f."<br>";
	        
	    }
	} 

	else {
	    echo "0 results";
	}	

}


$conn->close();

?>

</body>
</html>
