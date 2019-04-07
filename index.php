<?php 
session_start();

if(isset($_SESSION["user"]))
{
	header('location:welcome.php');
}


if(isset($_POST["submit"]))
{
    if(!empty($_POST["email"]) && !empty($_POST["password"]))
	{
		$mail = $_POST["email"];
		$pass = $_POST["password"];
		$raspa ="";
		
		function test_input($data) 
		{
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		}
		
		$status = 1;
		
		$mail = test_input($mail);
		if (filter_var($mail, FILTER_VALIDATE_EMAIL)) 
		{
		  $email = $mail;
		}
		else
		{
		  $status = 0;
		}
		
		$pass = test_input($pass);
		if (preg_match("/^[a-zA-Z ]*$/",$pass)) 
		{
		  $password = $pass;
		}
		else
		{
		  $status = 0;
		}
		
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
		
		if($status == 1)
		{
			if ($CONNPDO != null)
			{
				$getdata_PRST = $CONNPDO->prepare("SELECT * FROM accounts WHERE mail = :mail");
				$getdata_PRST->bindValue(":mail", $email);
				$getdata_PRST->execute() or die($CONNPDO->errorInfo());
				$count = $getdata_PRST->rowCount();
				
			   if($count == 1)
			   {
					while($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) 
					{ 
						$hashed_password = $getdata_RSLT["password"];
						if(password_verify($password, $hashed_password))
						{
							$user = $getdata_RSLT["username"];
							$_SESSION["user"] = $user;
							$raspa = "<span style='color:green;'>Welcome back! :)</span> ";
							header("Location:welcome.php");

							
						}
						else
						{
							$raspa = "<span style='color:red;'>Password is incorrect</span> ";
						}
						
						
					}
							
			   }
			   else
			   {
				   
				   $raspa = "<span style='color:red;'>The account doesn't exist!</span>";
				  
			   }
			}
			else
			{
				$raspa = "<span style='color:red;'>Internal error occured we apologise for the inconvenience!</span>";
				
			}
		}
		else
		{
			$raspa = "<span style='color:red;'>Please insert proper credentials!</span>";
		}
		
		
			
	}
	else
	{ 
		  $raspa = "<span style='color:red;'>Please insert all credentials!</span>";
	} 
}
else
{
	$raspa = "";
}	
	


?>


<!DOCTYPE html>
<head>
  <title>Log In</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <link href='http://fonts.googleapis.com/css?family=Signika:600,400,300' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  .center-justified 
  {
	  text-align: justify;
	  width: 100%;
	  max-width: 600px;
	  margin: 0 auto;
	  padding: 30px 0;

  
  
  }
  .nav.navbar-nav 
  {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
  }
  @media (min-width: 768px) 
  {
    .navbar-nav 
	{
        float: none;
    }
  }

  .center_div
  {
    margin: 0 auto;
    width:30% /* value of your choice which suits your alignment */
  }
  </style>
</head>
<body>
<header>
<nav class="navbar navbar-default">
  <div class="container-fluid">
   <ul class="nav navbar-nav">
      <li class="active"><a href="#">Αρχική</a></li>
      <li><a href="#">Υπηρεσίες</a></li>
	  <li><a href="#">Προφίλ</a></li>
	  <li><a href="#">Προϊόντα</a></li>
      <li><a href="#">Επικοινωνία</a></li>
    </ul>
  </div>
</nav>
</header>
<section>
 <div class="container">
 <p class="center-justified width:45%" style="word-wrap: break-word;">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eu lacinia arcu, ut tempus erat.Vestibulum ex nibh, eleifend at dolor ut, molestie laoreet felis. Cras sodales fringilla nisl,in mattis arcu imperdiet ut. Quisque eget eros placerat, blandit libero nec, euismod libero. Nam molestie elementum mi quis vestibulum. Donec nec volutpat nibh, eu commodo dui. Donec elit ligula, pretium sit amet viverra eget, faucibus quis arcu. Suspendisse efficitur nisi ullamcorper, ultrices nunc eget, lobortis eros. Duis sagittis, orci ut luctus hendrerit, dui arcu efficitur tortor, a lobortis eros odio nec tortor. Phasellus vel risus libero. Morbi varius tristique fringilla. Nunc malesuada, turpis non sodales consequat, quam felis rhoncus eros, eu fermentum dui ex vitae purus. 
 </p>
 <br>
 <h3 style="text-align:center;">Log In</h3>
 <br>
  <form class="form-horizontal" method="post" action = "<?php echo $_SERVER["PHP_SELF"]; ?>">
  <div class="input-group center_div">
    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
    <input id="email" type="text" class="form-control" name="email" placeholder="Email" style="width:300px;">
  </div>
  <br>
  <div class="input-group center_div">
    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
    <input id="password" type="password" class="form-control" name="password" placeholder="Password" style="width:300px;">
  </div>
  <br><br>
  <center>
  <div class="input-group">
    <input type="submit" class="btn btn-primary" name="submit" value="Log In">
  </div>
  </center>
  </form> 
  </div>
  <br><br>
  <div style="text-align:center;">
   <span><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;<a href="signup.php">New Account</a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><a href="#">Forgot Password</a></span>
  </div>
  <br><br>
</section>
<section>
	<div class="container">
	<center>
		<?php echo $raspa;  ?>
	</center>
	<br>
	<br>
	<br>
	</div>
</section>
</body>
</html>
