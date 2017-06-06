<?php require_once('functions/index.php');

if(logged_in() == false){
  header('Location: ./login');
  die;
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
    <link href="<?= PATH ?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= PATH ?>/css/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?= DISTRICT_NAME ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <?php if(user_info('role') == 1){ ?>
            <li><a href="<?= PATH ?>/">Dashboard</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li<?php if($row['name'] == str_replace("-"," ",$_GET['program'])){ $active = " class='active'"; }else{ $active = ""; } ?>><a href="<?= PATH ?>/programs/<?= $_GET['program'] ?>/settings">Settings</a></li>
                <li><a href="<?= PATH ?>/programs/<?= $_GET['program'] ?>/kiosks">Kiosks</a></li>
              </ul>
            </li>
            <?php } ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome <?= user_info('fullname'); ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <?php if(user_info('role') != 1){ ?><li><a href="/profile">Account Settings</a></li><?php } ?>
                <li role="separator" class="divider"></li>
                <li><a href="<?= PATH ?>/login?action=logout">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
        </div>
        
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Sign In</th>
                  <th>Sign Out</th>
                  <th><?php echo $program['settings']['desc_title']; ?></th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
               <?php
               
               $program_sql = "SELECT * FROM " . PREFIX . "programs WHERE Name='" . str_replace("-"," ",$_GET['redir']) . "'";
              $program_result = $conn->query($program_sql);
              $program = $program_result->fetch_assoc();
              $program['settings'] = unserialize($program['settings']);
               
                $sql = "SELECT * FROM " . PREFIX . "data WHERE Program='" . $program['ID'] . "' AND ID='" . $_GET['id'] . "'";
                    
                $result = $conn->query($sql);
                
                $count=0;
                if ($result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                      $CheckIn = $row['Signin'];
                      $CheckOut = $row['Signout'];
                      
                      echo "<form action='action.php'><tr>";
                      echo "<input type='hidden' name='page' value='data'>";
                      echo "<input type='hidden' name='action' value='edit'>";
                      echo "<input type='hidden' name='id' value='" . $row['ID'] . "'>";
                      echo "<input type='hidden' name='redir' value='" . $_GET['redir'] . "'>";
                      echo "<td><input type='text' name='name' value='" . $row['Name'] . "'></td>";
                      echo "<td><input type='text' name='in' value='" . $CheckIn . "'></td>";
                      echo "<td><input type='text' name='out' value='" . $CheckOut . "'></td>";
                      echo "<td><input type='text' name='desc' value='" . $row['Description'] . "'></td>";
                      echo "<td><input class='btn btn-success' type='submit' value='Save'></td>";
                      echo "</tr></form>";
                    }
                }else{
                  
                  echo "<tr><td colspan='6' style='text-align:center;'>No Results Found</td></tr>";
                }
               ?>
              </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?= PATH ?>/js/bootstrap.min.js"></script>
  </body>
</html>
