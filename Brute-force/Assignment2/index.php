 <!DOCTYPE html>
<html>
<head>

</head>
<body>
<h2>Assignment2: Mongo Database </h2>

<fieldset >

<p>1)district which has the most crime </p>
<p> 2)most inefficient police station in completing investigations</p>
<p> 3)most and least uniquely applied  crime laws  in FIRs </p>
</fieldset >
<?php 
require '/var/www/html/vendor/autoload.php'; 

$conn = new MongoDB\Client("mongodb://localhost:27017");

$db = $conn->firdata;
$collection = $db->cases;

$pipeline1 = array(
	array('$group' => array('_id' => array('DISTRICT' => '$DISTRICT'),'Total_Cases' => array('$sum' =>1),'PS' =>array('$addToSet' => '$PS'))),
	array('$project' => array('DISTRICT' =>1,'PS'=> array('$size' =>'$PS'),'Total_Cases' =>1)),
	array('$project' =>array('DISTRICT' =>1,'Total_Cases'=>1,'Ratio'=>array('$divide'=> array('$Total_Cases','$PS')))),
	array('$sort' => array('Ratio' => -1)),
	array('$limit' => 1),

);

$pipeline2 = array(
	array('$project' => array('Status' =>1, 'PS' =>1, '_id'=>0, 'Date' =>array('$substr' => array('$Registered_Date', 0,10)))),
	array('$project' => array('Status' =>1, 'PS' =>1, '_id'=>0, 'Date' => array('$toDate' => '$Date'),'Other' => array('$toDate' => "2018-09-29"))),
	array('$project' => array('Status' =>1, 'PS' =>1, '_id'=>0, 'Time_Taken' => array('$subtract' => array('$Other','$Date')))),
	array('$match' => array('Status' => "Pending")),
	array('$group' => array('_id' => array('PS' =>'$PS'),'Total_Time' => array('$sum' => '$Time_Taken'))),
	array('$sort' => array('Total_Time' => -1)),
	array('$limit' => 1)

);

$pipeline3 = array(
	array('$unwind' => '$Act_Section'),
	array('$group' => array('_id' => array('ACT' => '$Act_Section'),'Count' =>array('$sum' =>1))),
	array('$sort' => array('Count' => -1)),
	array('$limit' =>1)
);

$pipeline4 = array(
	array('$unwind' => '$Act_Section'),
	array('$group' => array('_id' => array('ACT' => '$Act_Section'),'Count' =>array('$sum' =>1))),
	array('$sort' => array('Count' => 1)),
	array('$limit' =>1)
);

$out1 = $collection->aggregate($pipeline1);
$out2 = $collection->aggregate($pipeline2);
$out3 = $collection->aggregate($pipeline3);
$out4 = $collection->aggregate($pipeline4);

 foreach ($out1 as $document) {
 			// echo "hello";
 	      echo "(1)DISTRICT : ".$document['_id']->DISTRICT ." Number Of crime reports = ".$document['Total_Cases']." Crime per Police station = ".$document['Ratio'] ;
     echo "<br>";
 }

foreach ($out2 as $document) {
 			// echo "hello";
 	      echo "(2)PS : ".$document['_id']->PS." Total_Time wasted = ".$document['Total_Time'];
     echo "<br>";
 }
 foreach ($out3 as $document) {

 	      echo "(3a)ACT : ".$document['_id']->ACT." Count = ".$document['Count'];
     echo "<br>";
 }
 foreach ($out4 as $document) {

 	      echo "(3b)ACT : ".$document['_id']->ACT." Count = ".$document['Count'];
     echo "<br>";
 }


?>
</body>
</html>

