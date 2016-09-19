<h2 class="sub-header">Programs</h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Kiosks</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

    <?php $sql = "SELECT * FROM " . PREFIX . "programs";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          if(!empty($row['kiosks'])){ $kiosks = implode(',', unserialize($row["kiosks"])); }else{ $kiosks = ''; }
            echo "<tr><td>" . $row["ID"]. "</td><td>" . $row["name"]. "</td><td>" . $kiosks . "</td><td><a class='btn btn-info' href='/programs/" .  str_replace(" ","-",$row['name']) . "/kiosks'>Edit</a> <a class='btn btn-success' href='/programs/" . str_replace(" ","-",$row['name']) . "'>Open</a> <a class='btn btn-danger' href='/action.php?page=programs&action=delete&content=" . $row['ID'] . "'>Delete</a></td></tr>";
        }
    } else {
        echo "0 results";
    }
    
    ?>
    <tr><form action="/action.php">
      <td><input type="hidden" name="action" value="create"><input type="hidden" name="page" value="programs"></td>
      <td><input class="form-control" type="text" name="content"></td>
      <td></td>
      <td><input type="submit" class="btn btn-success" value="Create"></td></form>
    </tr>
    </tbody>
  </table>
</div>
