<?php
if(isset($_POST["mail"]))
{
	function test_input($data) 
    {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$email = test_input($_POST["mail"]);
		
	if(filter_var($email, FILTER_VALIDATE_EMAIL))
	{
	    $mail = $_POST["mail"];
		
		$hostname_DB = "127.0.0.1";
		$database_DB = "digitalup";
		$username_DB = "root";
		$password_DB = "";

		try 
		{
			$CONNPDO = new PDO("mysql:host=".$hostname_DB.";dbname=".$database_DB.";charset=UTF8", $username_DB, $password_DB, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 3));
		} 
		catch (PDOException $e) 
		{
			$CONNPDO = null;
		}
		
		if($CONNPDO != null)
		{
			$getdata_PRST = $CONNPDO -> prepare("SELECT * FROM accounts WHERE mail = :mail");
			$getdata_PRST -> bindValue(":mail",$mail);
			$getdata_PRST -> execute() or die($CONNPDO->errorInfo());
			$count = $getdata_PRST ->rowCount();
			
			if($count != 0)
			{
				echo "<span style='color:red;'>Email is already used!</span>";
			}
			else
			{
				echo "<span style='color:green;'>Email is not used!</span>";
			}
		}
		else
		{
			echo "No connection!";
		}
	}
	else
	{
		echo "<span style='color:red;'>Insert proper email</span>";
	}
		
}



?>