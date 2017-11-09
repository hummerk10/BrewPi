<?php

$target_dir = "uploads/";

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;

$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image

/*
if(isset($_POST["submit"])) {

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
	echo "6";
}
*/
//echo $_FILES["fileToUpload"]["tmp_name"];
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
{
   echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    }
 else
 	 {
        echo "Sorry, there was an error uploading your file.";
	 }

// read file and parse out

echo "</br>";

$myfile = fopen( "/var/www/brewery/inc/site/uploads/".$_FILES["fileToUpload"]["name"], "r") or die("Unable to open file!");



while(!feof($myfile)) 
{
$iden = false;
$val = false;
$key = null;
$value = Null;
$line = fgets($myfile);

// look through each character

for ($i=0; $i!=strlen($line); $i++)
{
	if (substr($line,$i,2) == "</") // start Key	
	{
		break;
	}
	if (substr($line,$i,1) == "<") // start Key
	{
		$i++;
		$iden=true;
	}
	if (substr($line,$i,1) == ">" && $iden == true) // end Key
	{
		$iden=FALSE;
		$val = true;
		$i++;
	}
	if ($iden == true)
	{
	$key.=substr($line,$i,1);
	}
	if ($val == true)
	{
		$value.=substr($line,$i,1);
	}
	//echo substr($line,$i,1);
} 

echo "key = ".$key." ";
echo "\n";
echo "Value = ".$value;
echo "\n";


 	/*
  // Read characters to find < WORD >  Stop at </WORD >
  $char=fgetc($myfile);
  
  if ($char == "<") // look foor < 
  {$word = null;
  	$key=false;
   	// loop untill ">"
   	// Find Key
  	while ($char != ">") //stop at > 
  	{
  		$char=fgetc($myfile);
		if ($char =="/")
		{
			 while ($char != ">") 
			{
			$char=fgetc($myfile);
			}		
			break;
		}
		$word .= $char; 
			
	}
	$word = rtrim($word,">");
	
	While ($key == true)
	
	echo "</br>";
	echo "word =" .$word;
  }
   
	  */
  }
	 
	 
fclose($myfile);






?>