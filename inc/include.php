<?php 

ob_start();
session_start();
//print_r($_SESSION);

//echo $_SESSION['ID'];

include('inc/mysql.php');
include('inc/config.php');

$db		= new mysql($mysql);
$err	= false;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
	$clean	= clean_array($_POST, $db);

	

switch ($_GET['page']) {
	default:
		$page	= 'welcome';
		break;
	case 'config':
		$page	= 'config/config';
		break;
	case 'home':
		$page	= 'home';
		break;		
	case 'LogOut':
		//echo "Logging Out";
		$_SESSION['username']= null;
		break;	
	case 'AddRecipe':
		$page	= 'AddRecipe';
		break;
	case 'Brew':
		$page	= 'Brew';
		break;
	case 'History':
		$page	= 'History';
		break;				
}


if (isset($_GET['Recipe']))
{
	$_SESSION['RecipeID'] =$_GET['Recipe']; 	
	$page	= 'Brew';
}



if (!isset($_SESSION['username']))
{
	$page	= 'welcome';
}


//login
if ($page=='welcome' && isset($_POST['username']))
{

	$sql = "SELECT * FROM `TDLBrewingContoller`.`Users` WHERE Username='{$clean['username']}'";
	$q = $db->q($sql);
	//echo $sql.'<br />';
	if ($db->num($q) == 1)
	{
		$r	= $db->r($q);

		if (sha1( stripslashes($_POST['password']) ) == $r[0]['Password'])
		{
			$_SESSION['username']=$r[0]['Username'];
			$_SESSION['ID']=$r[0]['ID'];
			$_SESSION['RecipeID'] = null;
			$page	= 'home';
			
		}
		else
			{
			$err = "Wrong username or password!";
			echo "Wrong username or password!";
			$logged_in = false;
			}
	}
	
}



//register

// add username check.  Duplicate email check. 

if (isset($_POST['Name']))
{

	$Name= $_POST['Name'];
	$Email= $_POST['Email'];
	$Username= $_POST['Username'];
	$Password= $_POST['Password'];
	
	// Generate random ID
	$ID = randID();
	// is ID in use? 
	$inserted = false;
	$loop = 0;
	
	while($inserted != true OR $loop!=10)
	{
		++$loop;
	$sql = "SELECT * FROM `TDLBrewingContoller`.`Users` where `ID` = ". $ID;
	$q = $db->q($sql);
	if ($db->num($q) < 1)
		{
			// if yes , insert
		//echo "insert!";
		$inserted = true;
		$loop =10;
		}
	else 
		{
			// if no, make new ID and check again
		echo "FAIL";
		$ID = randID();
		}
	}
		
	

	$sql="INSERT INTO `TDLBrewingContoller`.`Users`
(`ID`,
`Username`,
`Password`,
`Name`,
`Email`)
VALUES
('$ID',
'$Username',
SHA1('$Password'),
'$Name',
'$Email');";
	 //echo $sql;
	 $db->q($sql);
	 
	if ($db->q($sql) === TRUE) 
	{
	echo "New record created successfully";
	 //$page='home';
	} 
	else 
	{
    //echo "Error";
	}
	//redirect("home");

}




//if ($page=='AddRecipe' && isset($_FILES['fileToUpload']))
{
//	echo "1234";
//	echo $_FILES['fileToUpload'];
//	$page	= 'AddRecipe';
//	echo "5678";
}



if ($page=='AddRecipe' && $_POST['submit']=='submit')
{
		
	$BrewID = $_SESSION['ID'];
	$Name= $_POST['RecipeName'];
	$MashTemp= $_POST['MashTemp'];
	$MashInVolume= $_POST['MashInVolume'];
	$MashTime= $_POST['MashTime'];
	$MashOutTemp = $_POST['MashOutTemp'];
	$runnings = $_POST['Runnings'];
	$ID = randID();
	
	$sql="INSERT INTO `TDLBrewingContoller`.`recipe`
(`ID`,
`Name`,
`MashInTemp`,
`MashInVol`,
`MashTime`,
`MashOutTemp`,
`BrewerID`,
`MashRun`)
VALUES
('$ID',
'$Name',
$MashTemp,
$MashInVolume,
$MashTime,
$MashOutTemp,
'$BrewID',
$runnings);";
	 //echo $sql;
	 //$db->q($sql);
	 
	if ($db->q($sql) === TRUE) 
	{
	//echo "New record created successfully";
	 $page='home';
	} 
	else 
	{
    echo "Error";
	}
	//redirect("home");
}

 

function redirect ($page) {
	$page	= 'home';	
	//header ('Location: /' . $page. '/');
	include ('inc/include_end.php');
}

function clean_array ($array, $db) {
	$clean = array();
	foreach ($array as $key => $val)
		$clean[$key] = $db->clean( stripslashes($val) );

	return $clean;
}


function randID()
{
	$a_z = "abcdefghijklmnopqrstuvwxyz0123456789";
	
	$ID=null;

	
	for ($x = 0; $x <= 20; $x++) 
	{
		$int = rand(0,35);	
		$rand_letter = $a_z[$int];
		//echo $rand_letter;
		$ID .= $rand_letter;
					
	}
    
	return $ID;	
}

