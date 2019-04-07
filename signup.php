<?php 
session_start();

if(isset($_SESSION["user"]))
{
	header("Location:welcome.php");
}

if(isset($_POST["submit"]))
{
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
	
	
    if(!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["password2"]))
	{  
		function test_input($data) 
		{
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		}
		
		$status = 1;
		$response = "";
		
		$name = test_input($_POST["username"]);
		if (preg_match("/^[a-zA-Z ]*$/",$name)) 
		{
		  $username = $name;
		}
		else
		{
		  $status = 0;
		}
		
		$pass = test_input($_POST["password"]);
		if (preg_match("/^[a-zA-Z ]*$/",$pass)) 
		{
		  $password = $pass;
		  $passhash = password_hash($password, PASSWORD_DEFAULT);
		}
		else
		{
		  $status = 0;
		  $response .= "<span style='color:red;'>Not proper username is inserted!</span><br>";
		}
		
		$pass2 = test_input($_POST["password2"]);
		if(preg_match("/^[a-zA-Z ]*$/",$pass2)) 
		{
		  if(password_verify($pass2, $passhash))
		  {
			$password = $passhash;
		  }
		}
		else
		{
		  $status = 0;
		}
		
		$email = test_input($_POST["email"]);
		
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
		  $mail = $_POST["email"];
		}
		else
		{
		  $status = 0;
		}
		
		if($CONNPDO != null)
		{
			$getdata_PRST = $CONNPDO ->	prepare("SELECT * FROM accounts WHERE mail = :mail");
			$getdata_PRST -> bindValue(":mail",$mail);
			$getdata_PRST -> execute() or die ($CONNPDO->errorInfo());
			$count = $getdata_PRST->rowCount();
			
			if($count != 0)
			{
				$status = 0;
			}
			
		}
		else
		{
			$status = 0;
			$response = "No db connection";
		}
		
		if($status == 1)
		{
			if($CONNPDO != null)
			{
				$adddata_PRST = $CONNPDO -> prepare("INSERT INTO accounts(username,password,mail) VALUES (:username,:password,:mail)");
				$adddata_PRST -> bindValue(":username",$username);
				$adddata_PRST -> bindValue(":password",$password);
				$adddata_PRST -> bindValue(":mail",$mail);
				$adddata_PRST -> execute() or die($CONNPDO->errorInfo());
			
				$response = "<span style='color:green;'>Registration has been successful!Please go to <a href='index.php'>Log In</a> page</span>";
			}
			else
			{
				$response = "<span style='color:red;'>A technical error has occured!Thank you for your understanding!</span>";
			}
			
		}
		else
		{
		  $response = "<span style='color:red;'>Please insert proper credentials!</span>";
		}
	}
	else
	{
		$response = "<span style='color:red;'>Please fill all the fields,Thank you!</span>";
	}
}
else
{
	$response = "";
}	
?>
<!DOCTYPE html>
<head>
  <title>Sign up today!</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <link href='http://fonts.googleapis.com/css?family=Signika:600,400,300' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
  function checkMail()
  {
	  var x = $("#email").val();
	    $.ajax(
		{
		type:'POST',
		data:{mail:x},
		url:'ajax/mailCheck.php',
		success:function(result)
		{
			$("#check").html(result);
					
		}
		});
	  
  }
  </script>
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
 <p class="center-justified ">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eu lacinia arcu, ut tempus erat.Vestibulum ex nibh, eleifend at dolor ut, molestie laoreet felis. Cras sodales fringilla nisl,in mattis arcu imperdiet ut. Quisque eget eros placerat, blandit libero nec, euismod libero. Nam molestie elementum mi quis vestibulum. Donec nec volutpat nibh, eu commodo dui. Donec elit ligula, pretium sit amet viverra eget, faucibus quis arcu. Suspendisse efficitur nisi ullamcorper, ultrices nunc eget, lobortis eros. Duis sagittis, orci ut luctus hendrerit, dui arcu efficitur tortor, a lobortis eros odio nec tortor. Phasellus vel risus libero. Morbi varius tristique fringilla. Nunc malesuada, turpis non sodales consequat, quam felis rhoncus eros, eu fermentum dui ex vitae purus. 
 </p>
 <br>
 <h3 style="text-align:center;">Create Account</h3>
 <br>
  <form class="form-horizontal " method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" >
  <div class="input-group center_div">
    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
    <input id="user" type="text" class="form-control" name="username" placeholder="Username" style="width:300px;">
  </div>
  <br>
  <div class="input-group center_div">
    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
    <span><input id="email" type="text" class="form-control" name="email" placeholder="Email" style="width:300px;" onkeyup="checkMail()"></span>
  </div>
  <span id="check" style="margin-left:35%;"></span>
  <br>
  <div class="input-group center_div">
    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
    <input id="password" type="password" class="form-control" name="password" placeholder="Password" style="width:300px;">
  </div>
  <br>
   <div class="input-group center_div">
    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
    <input id="password" type="password" class="form-control" name="password2" placeholder="Repeat Password" style="width:300px;">
  </div>
  <br><br>
  <center>
  <div class="input-group">
    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
  </div>
  </center>
  </form> 
  </div>
  <br><br>
  <div style="text-align:center;">
  <span>Do you already have an account? <span><a href="index.php">Sign In</a></span>
  </div>
  <br><br>
</section>
<section>
<div class="container">
<center>
<?php echo $response; ?>
</center>
<br><br><br>
</div>
</section>
</body>
</html>
