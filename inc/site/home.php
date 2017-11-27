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

</br>
<div class="row text-center">
  <div class="col-sm-4" style="background-image:url('inc/img/Vessel.jpg');background-repeat: no-repeat;background-position: center;background-size: auto auto;">
  <h2>HTL</h2>
  <h3>Temp:<?php echo $hlt ?></h3>
  </br>
  <button type="button" class="btn btn-primary">Primary</button>
  </br>
</div>
<div class="col-sm-4" style="background-image:url('inc/img/Vessel.jpg');background-repeat: no-repeat;background-position: center;background-size: auto auto;">
  <h2>Mash</h2> 
  <h3>Temp:<?php echo $mash ?></h3> 
  </br>
  <button type="button" class="btn btn-primary">Primary</button>
  </br>
 </div>
 <div class="col-sm-4" style="background-image:url('inc/img/Vessel.jpg');background-repeat: no-repeat;background-position: center;background-size: auto auto;">
  <h2>Boil</h2>
  <h3>Temp:<?php echo $boil ?></h3>
  </br>
  <button type="button" class="btn btn-primary">Primary</button>
  </br>

 </div>
</div>

<div class="row text-center">
  <div class="col-sm-6">
  <h2>Flow 1</h2>
  <h3> Gallons: 00 </h3>
  <button type="button" class="btn btn-primary">reset</button>
  </div>
  <div class="col-sm-6">
  <h2>Flow 2 </h2>
  <h3> Gallons: 00 </h3>
  <button type="button" class="btn btn-primary">reset</button>
  </div>

<div class="row text-center">
  <div class="col-sm-6">
  <h2>Pump 1</h2>
  <h3> Status: OFF </h3>
  <button type="button" class="btn btn-primary">ON/OFF</button>
  </div>
  <div class="col-sm-6">
  <h2>Pump 2 (NOT REAL) </h2>
  <h3> Status: OFF </h3>
  <button type="button" class="btn btn-primary">ON/OFF</button>  
  </div>
  
</div>
