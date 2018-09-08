 <!DOCTYPE html>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">

<h2>Check Train Avaibility </h2>
<form method="post" name="myform" action="">
  <fieldset >

Source station code:<input type="text" name="src" maxlength="4" id="myInput1">
<span class="error" id="nameid">*</span>
<br><br>
Destination station code:<input type="text" name="dst" maxlength="4" id="myInput1">
<span class="error" id="nameid">*</span>
<br><br>
<!-- Day:
 <select name="day">
    <option value="sun">Sunday</option>
    <option value="mon">Monday</option>
    <option value="tue">Tuesday</option>
    <option value="wed">Wednesday</option>
    <option value="thu">Thursday</option>
    <option value="fri">Friday</option>
    <option value="sat">Saturday</option>
 </select>
<br><br> -->



    <div class="form-row show-inputbtns">
    Date: <!-- <input type="date" name= "date" data-date-inline-picker="false" data-date-open-on-focus="true" /> -->
         <input type="date" name = "date"data-date-inline-picker="false" data-date-popover='{
    "inline": true
}' />
    <br><br>
    </div>



<input type="submit" name="submit" value="submit">
<!-- <input type="reset" value="Clear"> -->
</fieldset >

</form>

</body>
</html>
<?php
if(isset($_POST["submit"])){
	 $src = $_POST["src"];
	 $dst = $_POST["dst"];
	 $day = $_POST["date"];
	 echo $src;
     echo "</br>";
     echo $dst;
     echo "</br>";
     echo $day;	
     echo "<br>";
     $req = "https://api.railwayapi.com/v2/between/source/".$src."/dest/".$dst."/date/28-08-2018/apikey/y22hvd4vm6/";
     $req2 = "http://api.erail.in/live/?key=y22hvd4vm6&trainno=12138&stnfrom=NDLS&date=05-SEP-2018";
     $req1 = "iitk.ac.in";
     $ch = curl_init();
     curl_setopt($ch,CURLOPT_URL,$req1);
     curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
     // curl_setopt($ch,CURLOPT_HEADER, true); // for headers
     $output=curl_exec($ch);
     echo $output;
     curl_close($ch);


}
?>