<?php

$sql		= "SELECT datetime, value, point FROM `temp` where datetime in ( select max(datetime) from `temp` group by point )";
//echo $sql;
$r			= $db->g($sql);

foreach ($r as $num => $row) {
  if ($row['point'] == 1)
    {$hlt=$row['value'];}
    if ($row['point'] == 2)
    {$mash=$row['value'];}
    if ($row['point'] == 3)
    {$boil=$row['value'];}
  
	

}
?>


<div class="row text-center">
  <div class="col-sm-4">
  <h2>HTL</h2>
  <h3>Temp:<?php echo $hlt ?></h3>
    <img src="inc/img/Vessel.jpg." alt="HLT">
</div>
 <div class="col-sm-4">
  <h2>Mash</h2> 
  <h3>Temp:<?php echo $mash ?></h3> 
  <img src="inc/img/Vessel.jpg." alt="Mash">
 </div>
 <div class="col-sm-4">
  <h2>Boil</h2>
  <h3>Temp:<?php echo $boil ?></h3>
  <img src="inc/img/Vessel.jpg." alt=Boil">
 </div>
</div>

<div class="row text-center">
  <div class="col-sm-6">
  <h2>Flow 1</h2>
  <h3> Gallons: 00 </h3>
  </div>
  <div class="col-sm-6">
  <h2>Flow 2 </h2>
  <h3> Gallons: 00 </h3>
  </div>

<div class="row text-center">
  <div class="col-sm-6">
  <h2>Pump 1</h2>
  <h3> Status: OFF </h3>
  </div>
  <div class="col-sm-6">
  <h2>Pump 2 (NOT REAL) </h2>
  <h3> Status: OFF </h3>
  </div>
  
</div>
