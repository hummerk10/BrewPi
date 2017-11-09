<?php 
//echo "selected beer =";
//echo $_SESSION['RecipeID'];
$BrewID = $_SESSION['ID'];

if (!isset($_SESSION['RecipeID']))
{

?>
<div class="row">
</br>
<div class="col-sm-offset-2 col-sm-3 ">
<h4> Which of your recipes do you want to brew??</h4>
  
  			<form name="form1" method="get">
				<?php
				$sql="SELECT `recipe`.`ID`,`recipe`.`Name`
   				FROM `TDLBrewingContoller`.`recipe` where `BrewerID` =  '$BrewID'";
				//echo $sql;
				$r	= $db->g($sql);

				foreach ($r as $num => $row) {
				$RepID = $row['ID'];
				$name = $row['Name'];
				?>
				<button type="submit" name="Recipe" value="<?php	echo $RepID; ?>" class="btn btn-primary btn-md "><?php	echo $name; ?></button>
				<?php
				}
				?>
				
			</form>
</div>

</div>


<?php 
}

//echo $_SESSION['RecipeID'];

if (isset($_SESSION['RecipeID']))
{
$RecipeID = $_SESSION['RecipeID'];
				
				$sql="SELECT `recipe`.`Name`,`recipe`.`MashInVol`,`recipe`.`MashTime`,`recipe`.`MashOutTemp`,`recipe`.`MashRun`,`recipe`.`MashInTemp`
   				FROM `TDLBrewingContoller`.`recipe` where `ID` =  '$RecipeID'";
				//echo $sql;
				$r	= $db->g($sql);

				foreach ($r as $num => $row) {
				$name = $row['Name'];
				$MashInVol = $row['MashInVol'];
				$MashTime = $row['MashTime'];
				$MashOutTemp = $row['MashOutTemp'];
				$MashRun = $row['MashRun'];
				$MashInTemp = $row['MashInTemp'];
				}
				


?>

<div class="row">
</br>
<div class="col-sm-12 text-center ">
<h2> You are brewing <?php echo $name;?></h2>
<h4>THIS IS WHERE I WILL PUT THE STEPS</h4>
</div>
</div>

<div class="row">
</br>
<div class="col-sm-offset-2 col-sm-3 ">
<h4>HLT DATA</h4>
<?php
echo "show HLT temp</br>";
echo "show if Element is on or not</br>";
echo "Turn element On off or Auto </br>";
echo "Mash in temp: ".$MashInTemp;

?>
</div>

<div class="col-sm-3 ">
<h4>MASH Data</h4>
<p>
	<?php
						echo "MashInVol: ".$MashInVol."</br>";
					echo "MashTime: ".$MashTime."</br>";
					echo "Actual Mash Temp</br>";
					echo "Target Mash Temp</br>";
					echo "MashOutTemp: ".$MashOutTemp."</br>";
					
	?>
</p>
</div>
<div class="col-sm-3 ">
<h4>Boil Data</h4>
<?php
echo " Projected Collected Runnings:".$MashRun."</br>";
echo " Actual collected runnings</br>";
?>
</div>
</div>

<?php 
}

?>