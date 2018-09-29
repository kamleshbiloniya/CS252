 <!DOCTYPE html>
<html>
<head>
<!-- <a href="video.php">link</a>
<a href = "webcam.php">webcam page</a> -->
</head>
<body>
<h2>Mongo Database Demo </h2>

<fieldset >

<p>district which has the most crime </p>
<p> most inefficient police station in completing investigations</p>
<p> most and least uniquely applied  crime laws  in FIRs </p>
</fieldset >
<?php 
require '/var/www/html/vendor/autoload.php'; 
echo "hi";
$conn = new MongoDB\Client("mongodb://localhost:27017");

$db = $conn->firdata;
$collection = $db->cases;
// var_dump($collection);
// $result = $collection->insertOne( [ 'name' => 'Hinterland', 'brewery' => 'BrewDog' ] );
// echo "Inserted with Object ID '{$result->getInsertedId()}'";
// $cursor = $collection->find(['PS' => 'CHHATTA']);
echo "working";



$pipeline = array(  array(
        '$group' => array(
            '_id' => array('DISTRICT' => '$DISTRICT' , 'PS' => '$PS'),
            // 'sum' => array('$sum' => '$1' )
        )
    ),
    array(
        '$group' => array(
            '_id' => '$_id.DISTRICT',
            )
        )
    ),
 );



$out = $collection->aggregate($pipeline);

var_dump($out);




// $cursor = $collection->find(['DISTRICT' => 'AGRA']);
// var_dump($cursor);

 // echo "<br>";
// foreach ($cursor as $document) {
// 	// echo "hello";
//     echo $document['_id'] . " : ".$document["PS"] ." : ".$document["RANGE_NAME"];
//     echo "<br>";
// }

?>
</body>
</html>

