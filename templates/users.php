<h2 class="sub-header">Users</h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Username</th>
          <th>Email</th>
          <th>Programs</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

    <?php $sql = "SELECT * FROM " . PREFIX . "users";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if($row['ROLE'] == 1){ $role = ' <span class="label label-default">Administrator</span>'; }else{ $role =''; }
            if(empty($row["ACCESS"])){ $implode = implode(',', unserialize($row["ACCESS"])); }else{ $implode = ""; }
            echo "<tr><td>" . $row["ID"]. "</td><td>" . $row["FULLNAME"].$role .  "</td><td>" . $row["USERNAME"]. "</td><td>" . $row["EMAIL"]. "</td><td>" . $implode . "</td><td><a class='btn btn-info' href='" . PATH . "/admin/users/edit/" . $row['ID'] . "'>Edit</a></td></tr>";
        }
    } else {
        echo "0 results";
    }
    
    ?>
    <tr><form action="<?= PATH ?>/action.php">
      <td><input type="hidden" name="action" value="create"><input type="hidden" name="page" value="users"></td>
      <td><input class="form-control" type="text" name="name"></td>
      <td><input class="form-control" type="text" name="username"></td>
      <td><input class="form-control" type="text" name="email"></td>
      <td></td>
      <td><input type="submit" class="btn btn-success" value="Create"></td></form>
    </tr>
    </tbody>
  </table>
</div>
