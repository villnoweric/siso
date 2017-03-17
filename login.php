<?php require_once('functions/index.php');

if(isset($_GET['action'])){
  if($_GET['action'] == 'logout'){
    setcookie('USERNAME', null, -1);
    setcookie('PASSWORD', null, -1);
    header('Location: ./');
    die;
  }
}

if(logged_in()){
  header('Location: ./');
  die;
}

if(isset($_POST['username'])){
  
  $password = $_POST['password'];
  $username = $_POST['username'];
  $password = md5($password);
  
  $sql="SELECT * FROM " . PREFIX . "users WHERE username='" . $username . "' AND password='" . $password . "'";
  $result=mysqli_query($conn,$sql);
  if(mysqli_num_rows($result) > 0){
    if($_POST['remember']){
      $expire = 3600;
    }else{
      $expire = 0;
    }
      setcookie('USERNAME', $username, $expire);
      setcookie('PASSWORD', $password, $expire);
      header('Location: ./');
      die;
  }else{
     $error = "Incorrect Login Information";
  }
  
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= DISTRICT_NAME ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <?php if(isset($error)){ echo '<div class="alert alert-danger" role="alert"><center>' . $error . '<center></div>';} ?>
      <h2 class="form-signin-heading"><?= DISTRICT_NAME ?></h2>
      <form class="form-signin" method="post">
        <label for="inputEmail" class="sr-only">Username</label>
        <input type="text" name="username" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" name="remember" value="true"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <div class="hidden-lg">
          <br><br>
          <a class="btn btn-lg btn-info btn-block" href="kiosk">Is this a Kiosk?</a>
        </div>
      </form>
    </div><!-- /container -->
  </body>
</html>
