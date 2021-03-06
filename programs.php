<?php require_once('functions/index.php');

if(logged_in() == false){
  header('Location: ./login');
  die;
}

if(!isset($_GET['date'])){
  $date = date('Y-m-d');
  header('Location: ?date=' . $date);
}else{
  $date = $_GET['date'];
  $todays_date = date('Y-m-d');
  if(strtotime($todays_date) == strtotime($date)){
    $istoday = true;
  }else{
    $istoday = false;
  }
}

//FUNCTIONS
function previous_date($date){
  if(date('D', strtotime($date)) == 'Mon'){
    $previous = date('Y-m-d', strtotime('-3 day', strtotime($date)));
  }else{
  $previous = date('Y-m-d', strtotime('-1 day', strtotime($date)));
  }
  echo '<li><a href="?date=' . $previous . '">&lsaquo; Previous</a></li>';
}

function current_date($date){
  $current = strtotime($date);
  echo '<li><a href="?date=' . $date . '">' . date('l, F jS, Y', $current) . '</a></li>';
}

function next_date($date){
  $todays_date = date('Y-m-d');
  
  if(date('D', strtotime($date)) == 'Fri'){
    $next = date('Y-m-d', strtotime('+3 day', strtotime($date)));
  }else{
  $next = date('Y-m-d', strtotime('+1 day', strtotime($date)));
  }
  if($todays_date == $date){
    echo '<li class="disabled"><a href="#">Next &rsaquo;</a></li>';
  }else{
      $datecode = strtotime($date);
      echo '<li><a href="?date=' . $next . '">Next &rsaquo;</a></li>';
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
              
              $program_sql = "SELECT * FROM " . PREFIX . "programs WHERE Name='" . str_replace("-"," ",$_GET['program']) . "'";
              $program_result = $conn->query($program_sql);
              $program = $program_result->fetch_assoc();
              $program['settings'] = unserialize($program['settings']);
              
              if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                    if($row['name'] == str_replace("-"," ",$_GET['program'])){
                      $active = " class='active'";
                    }else{
                      $active = "";
                    }
                      echo '<li' . $active . '><a href="' . PATH . '/programs/' . str_replace(" ","-",$row['name']) . '">' . $row['name'] . '</a></li>';
                      $forward = str_replace(" ","-",$row['name']);
                  }
              }else{
                die('</ul></div><div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main"><div class="alert alert-danger">You have no programs assigned to you. Contact your administrator.</div>');
              }
              if ($result->num_rows == 1) {
                if(empty($_GET['program'])){
                //header('Location: /programs/' . $forward);
                echo '<script type="text/javascript">window.location = "' . PATH . '/programs/' . $forward . '";</script>';
                }
              }
            ?>
          </ul>
          <?php } ?>
        </div>
        <?php if(!empty($_GET['program'])){ ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <div class="clearfix">
            <?php if(!isset($_GET['list'])){ ?>
            <form method="get" style="display:inline-block;">
              <input type="hidden" name="date" value="<?= $date ?>">
              <ul class="pagination">
                <li><span><input class="form-control input-sm" type="text" name="search"></span></li>
                <li><span><input class="form-control input-sm" type="submit" value="Search"></span></li>
              </ul>
            </form>
            <?php } ?>
            <div class="pull-right">
              <ul class="pagination">
                <?php 
                if(isset($_GET['list'])){
                  echo '<li><a href="?date=' . $date . '">Cancel</a></li>';
                }
                if(isset($_GET['list']) && $_GET['list']!=1){
                  echo '<li><a href="?date=' . $date . '&list=1">List All Days</a></li>';
                }elseif($_GET['list']==1){
                  echo '<li><a href="?date=' . $date . '&list=0">List Today</a></li>';
                }else{
                echo '<li><a href="?date=' . $date . '&list=0">List</a></li>';
                }
                ?>
              </ul>
              <ul class="pagination">
                <?php if(!isset($_GET['list'])){ ?><li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sort <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="?date=<?php echo $date; ?>">All</a></li>
                    <li role="separator" class="divider"></li>
                    <?php
                    foreach ($program['settings']['descs'] as $value) {
                      echo "<li><a href='?date=" . $date . "&sort=" . $value . "'>" . $value . "</a></li>";
                    }
                    ?>
                    <?php if($program['settings']['other'] == 1){ ?><li><a href="?date=<?php echo $date; ?>&sort=other">Other</a></li><?php } ?>
                  </ul>
                </li><?php } ?>
                <li><a href="<?= $_GET['program'] ?>/export?date=<?= $date ?>"><span class="glyphicon glyphicon-download-alt"></span></a></li>
              </ul>
              <ul class="pagination">
                <?php previous_date($date); ?>
                <?php current_date($date); ?>
                <?php next_date($date); ?>
              </ul>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <?php if($program['settings']['signature'] == 1){ ?><th>Signature</th><?php } ?>
                  <th>Date</th>
                  <th>Sign In</th>
                  <th>Sign Out</th>
                  <?php if($program['settings']['duration'] == 1){ ?><th>Durration</th><?php } ?>
                  <th><?php echo $program['settings']['desc_title']; ?></th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
               <?php
               
               $grand_total = 0;
               
                $sql = "SELECT * FROM " . PREFIX . "data WHERE Program='" . $program['ID'] . "'";
                
                if(!isset($_GET['search'])){
                  if($_GET['list']!=1){
                    $sql .= " AND ( Signout LIKE '%$date%' OR Signin LIKE '%$date%' )";
                  }
                }else{
                    $query = $_GET['search'];
                    $sql .= " AND Name LIKE '%$query%'";
                }
               
                if(isset($_GET['sort'])){
                  $sort = $_GET['sort'];
                  if($sort != 'other'){
                    $sql .= " AND Description='$sort'";
                  }else{
                    $sql .= " AND Description LIKE 'Other:%'";
                  }
                }
                
                if(isset($_GET['list'])){
                    $sql .= " AND Signout IS NULL";
                }
                  
                $sql .= " ORDER BY ID ASC";
                    
                $result = $conn->query($sql);
                
                $count=0;
                if ($result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                      $CheckIn = $row['Signin'];
                      $CheckOut = $row['Signout'];
                      
                      if(empty($CheckOut)){
                          $Date = date('l, F j, Y', strtotime($CheckIn));
                      }else{
                          $Date = date('l, F j, Y', strtotime($CheckOut));
                      }
                      
                      if(empty($CheckIn)){
                          $CheckIn = "---";
                      }else{
                          $CheckIn = date("g:i:s A", strtotime($CheckIn));
                      }
                      
                      if(empty($CheckOut)){
                          $CheckOut = "---";
                          $total = "---";
                      }else{
                          $CheckOut = date("g:i:s A", strtotime($CheckOut));
                          if($CheckIn != "---"){
                            $total_time = round(abs(strtotime($CheckOut) - strtotime($CheckIn)) / 60,1);
                          $total = $total_time . " Minute(s)";
                          }else{
                             $total = "---";
                          }
                          $grand_total = $grand_total + $total_time;
                      }
                      
                      
                      $count = $count + 1;
                      
                      echo "<tr>";
                      echo "<td>" . $count . "</td>";
                      echo "<td>" . $row['Name'] . "</td>";
                      if($program['settings']['signature'] == 1){ 
                        if(is_null($row['Signature'])){ $signature = "No Signature"; }else{ $signature = "<img width='150px' src='" . $row['Signature'] . "'>"; }
                        
                        echo "<td>" . $signature . "</td>"; 
                        
                        
                      }
                  	  echo "<td>" . $Date . "</td>";
                      echo "<td>" . $CheckIn . "</td>";
                      echo "<td>" . $CheckOut . "</td>";
                      if($program['settings']['duration'] == 1){ echo "<td>" . $total . "</td>"; }
                      echo "<td>" . $row['Description'] . "</td>";
                      echo "<td>";
                      if($CheckOut=='---'){
                        echo "<a class='btn btn-info' href='../action.php?page=data&action=so&id=" . $row['ID'] . "&redir=" . $_GET['program'] . "'>Sign Out</a> ";
                      }
                      if(!isset($_GET['list'])){
                        echo "<a class='btn btn-danger' href='../action.php?page=data&action=delete&id=" . $row['ID'] . "&redir=" . $_GET['program'] . "'>Delete</a>";
                      }
                      if($row['Verify'] == 0){
                        echo "<a class='mdi-toggle-check-box-outline-blank' href='action.php?action=verify&value=" . $row['ID'] . "&date=" . $date . "'></a>";
                      }else{
                        echo "<a class='mdi-toggle-check-box' href='action.php?action=unverify&value=" . $row['ID'] . "&date=" . $date . "'></a>";
                      }
                      echo " <a class='btn btn-warning' href='../dataedit.php?id=" . $row['ID'] . "&redir=" . $_GET['program'] . "'>Edit</a>";
                      echo "</td>";
                      echo "</tr>";
                    }
                }else{
                  
                  echo "<tr><td colspan='9' style='text-align:center;'>No Results Found</td></tr>";
                }
               ?>
              </tbody>
              </table>
              <h3>
                <span class="label label-default">
                  <?php
                    if($grand_total < 60){
                      $label = " Minute";
                      if($grand_total != 1){
                        $label .= "s"; 
                      }
                      echo $grand_total . $label;
                    }else{
                      $label = " Hour";
                      if($grand_total != 1){
                        $label .= "s"; 
                      }
                      $grand_hrs = $grand_total / 60;
                      echo round($grand_hrs,1) . $label;
                    }
                  ?>
                </span>
              </h3>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?= PATH ?>/js/bootstrap.min.js"></script>
  </body>
</html>
