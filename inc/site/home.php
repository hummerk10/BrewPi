<?php
echo "<h1> welcome ". $_SESSION['username']. "</h1>"; 

$BrewID = $_SESSION['ID'];

$sql="SELECT `recipe`.`ID`,
    `recipe`.`Name`,
    `recipe`.`MashInTemp`,
    `recipe`.`MashInVol`,
    `recipe`.`MashTime`,
    `recipe`.`MashOutTemp`,
    `recipe`.`BrewerID`,
    `recipe`.`MashRun`
FROM `TDLBrewingContoller`.`recipe` where `BrewerID` =  '$BrewID'";

//echo $sql;

$r			= $db->g($sql);

foreach ($r as $num => $row) {
	$name = $row['Name'];
	echo $name;

	echo "<br>";
}

?>

<p>

	
</p>