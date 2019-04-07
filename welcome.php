<?php
session_start();
if(isset($_SESSION["user"]))
{
	$user = $_SESSION["user"];
	$response = "Welcome, <span style='color:blue;'>".$user."&nbsp;|&nbsp;<a href='signout.php'>Sign Out</a> ";
}
else
{
	header("Location:index.php");
}

?>

<!DOCTYPE html>
<head>
  <title>Welcome</title>
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
  <div class="container-fluid ">
   <ul class="nav navbar-nav">
      <li class="active"><a href="#">Αρχική</a></li>
      <li><a href="#">Υπηρεσίες</a></li>
	  <li><a href="#">Προφίλ</a></li>
	  <li><a href="#">Προϊόντα</a></li>
      <li><a href="#">Επικοινωνία</a></li>
    </ul>
	<span style="float:right;margin-top:15px;"><?php echo $response; ?></span>
  </div>
</nav>
</header>
<section>
 <div class="container">
 <center><h3>Welcome to Our Page</h3></center>
 <p class="center-justified">
 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eu lacinia arcu, ut tempus erat.Vestibulum ex nibh, eleifend at dolor ut, molestie laoreet felis. Cras sodales fringilla nisl,in mattis arcu imperdiet ut. Quisque eget eros placerat, blandit libero nec, euismod libero. Nam molestie elementum mi quis vestibulum. Donec nec volutpat nibh, eu commodo dui. Donec elit ligula, pretium sit amet viverra eget, faucibus quis arcu. Suspendisse efficitur nisi ullamcorper, ultrices nunc eget, lobortis eros. Duis sagittis, orci ut luctus hendrerit, dui arcu efficitur tortor, a lobortis eros odio nec tortor. Phasellus vel risus libero. Morbi varius tristique fringilla. Nunc malesuada, turpis non sodales consequat, quam felis rhoncus eros, eu fermentum dui ex vitae purus. 
 </p>
 <br>
 <br>
  <br><br>
</section>
</body>
</html>
