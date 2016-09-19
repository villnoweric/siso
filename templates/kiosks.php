<h2 class="sub-header">Registered Kiosks</h2>
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

<?php $sql = "SELECT * FROM " . PREFIX . "kiosks";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["ID"]. "</td><td>" . $row["apid"]. "</td><td>" . $row["name"]. "</td><td>" . date('F jS, Y',$row["expire"]) . "</td><td><a class='btn btn-danger' href='" . PATH . "/action.php?page=kiosks&action=delete&content=" . $row['ID'] . "'>UnRegister</a></td></tr>";
    }
} else {
    echo "<tr><td colspan='7'>0 results</td></tr>";
}

?>
    </tbody>
  </table>
</div>