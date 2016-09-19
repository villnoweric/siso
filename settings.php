<?php require_once('functions/index.php');

if(logged_in() == false){
  header('Location: /login');
  die;
}

$program_sql = "SELECT * FROM " . PREFIX . "programs WHERE Name='" . str_replace("-"," ",$_GET['program']) . "'";
$program_result = $conn->query($program_sql);
$program = $program_result->fetch_assoc();
$program['settings'] = unserialize($program['settings']);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= DISTRICT_NAME ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="/css/dashboard.css" rel="stylesheet">
    <link href="/css/fix.php?color=<?= COLOR ?>" rel="stylesheet">

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
            <li><a href="/">Dashboard</a></li>
            <li class="dropdown active">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li<?php if($_GET['action']=='settings'){ echo ' class="active"'; } ?>><a href="/programs/<?= $_GET['program'] ?>/settings">Settings</a></li>
                <li<?php if($_GET['action']=='kiosks'){ echo ' class="active"'; } ?>><a href="/programs/<?= $_GET['program'] ?>/kiosks">Kiosks</a></li>
              </ul>
            </li>
            <?php } ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome <?= user_info('fullname'); ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Separated link</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="/login?action=logout">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <?php if(user_role() == 1){ ?>
          <ul class="nav nav-sidebar">
            <?php
              if(user_info('role') == 1){
                $sql = "SELECT * FROM " . PREFIX . "programs";
              }else{
                $access = unserialize(user_info('access'));
                $sql = "SELECT * FROM " . PREFIX . "programs WHERE ID IN (" . implode(',', array_map('intval', $access)) . ")";
              }
              $result = $conn->query($sql);
              
              if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                    if($row['name'] == str_replace("-"," ",$_GET['program'])){
                      $active = " class='active'";
                    }else{
                      $active = "";
                    }
                      echo '<li' . $active . '><a href="/programs/' . str_replace(" ","-",$row['name']) . '">' . $row['name'] . '</a></li>';
                  }
              }else{
              }
            ?>
          </ul>
          <?php } ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"><?= ucfirst($_GET['action']) ?>  <span class="pull-right"><small><?= str_replace("-"," ",$_GET['program']); ?></small></span></h1>
          <?php if($_GET['action']=='settings'){ ?>
          <div class="col-md-4">
          <form action="/action.php" method="get">
          <h3 class="form-inline">Select a <input class="form-control input-lg" type="text" name="desc_title" value="<?= $program['settings']['desc_title'] ?>"></h3>
          <ul class="list-group">
            <textarea name="descs" class="form-control" rows="10" columns="20"><?php
                $i = 0;
                $len = count($program['settings']['descs']);
                foreach ($program['settings']['descs'] as $v) {
                  if ($i == $len - 1) {
                      echo $v;
                  } else {
                      echo $v . '&#10;';
                  }
                  $i++;
                }
              ?></textarea>

          </ul>
          <input type="hidden" name="action" value="update"/>
          <input type="hidden" name="page" value="settings"/>
          <input type="hidden" name="program" value="<?= $_GET['program']; ?>"/>
          <input type="hidden" name="other" value="0" />
          <input type="checkbox" name="other" value="1"<?php if($program['settings']['other'] == 1){ echo ' checked'; } ?>> Enable Other Option<br><br>
          
          <input type="hidden" name="single_instance" value="0" />
          
          <input type="hidden" name="single_transaction" value="0" />
          
          <input type="hidden" name="require_first" value="0" />
          
          <input type="radio" name="order" value="1"<?php if($program['settings']['order'] == 1){ echo ' checked'; } ?>> Sign In > Sign Out &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="order" value="0"<?php if($program['settings']['order'] == 0){ echo ' checked'; } ?>> Sign Out > Sign In<br><br>
          
          <input type="hidden" name="signature" value="0" />
          <!--<input type="checkbox" name="signature" value="1"<?php if($program['settings']['signature'] == 1){ echo ' checked'; } ?>> Capture Signature<br>-->
          <input type="hidden" name="duration" value="0" />
          <input type="checkbox" name="duration" value="1"<?php if($program['settings']['duration'] == 1){ echo ' checked'; } ?>> Calculate Duration<br><br>
          <input class="btn btn-default" type="submit">
          </form>
          </div>
          <?php } ?>
          <?php if($_GET['action']=='kiosks'){ ?>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Kiosk ID</th>
                  <th>Name</th>
                  <th>Expiration Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
          
              <?php 
              
              $sql = "SELECT * FROM " . PREFIX . "programs WHERE name='" . str_replace("-"," ",$_GET['program']) . "'";
              $result = $conn->query($sql);
              while($row = $result->fetch_assoc()){
              if(isset($row['kiosks'])){
                $kiosks = unserialize($row['kiosks']);
              }else{
                $kiosks = array();
              }
              }
              $sql = "SELECT * FROM " . PREFIX . "kiosks";
              $result = $conn->query($sql);
              
              if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                    
                      if(in_array($row['apid'], $kiosks)){
                        $button = "<a class='btn btn-danger' href='/action.php?page=settings&action=remove&program=" . $_GET['program'] . "&content=" . $row['apid'] . "'>Remove</a>";
                      }else{
                        $button = "<a class='btn btn-success' href='/action.php?page=settings&action=add&program=" . $_GET['program'] . "&content=" . $row['apid'] . "'>Add</a>";
                      }
                    
                      echo "<tr><td>" . $row["ID"]. "</td><td>" . $row["apid"]. "</td><td>" . $row["name"]. "</td><td>" . date('F jS, Y',$row["expire"]) . "</td><td>" . $button . "</td></tr>";
                  }
              } else {
                  echo "<tr><td colspan='7'>0 results</td></tr>";
              }
              
              ?>
              </tbody>
            </table>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
