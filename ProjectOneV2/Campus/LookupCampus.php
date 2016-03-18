<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT * FROM campus";

if($_SERVER["REQUEST_METHOD"] == "POST" )
{
  global $sql;
  $sql = "SELECT * FROM campus WHERE " . $_POST['key'] . " LIKE '". $_POST['keyword'] . "';";

}
function replaceSpace($string){
  return str_replace(" ","%",$string);
}
function populateTable(){
  global $sql;
  require '../Credential.php';
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  if( array_key_exists('key',$_GET) && array_key_exists('query',$_GET)){
    $sql = "SELECT * FROM campus WHERE " . $_GET['key'] . " LIKE '". $_GET['query'] . "';";
  }

  #echo $sql;
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $id = $row["id"];
      $Name = $row["Name"];
      $Abb = $row["Abb"];
      $Address =$row["Address"];
      $State = $row["State"];
      $Zip = $row["Zip"];
      $Country = $row["Country"];
      // echo $row["Building"] . '<br>';
      echo "<tr>
      <td>".$id."</td>
      <td>".$Name."</td>
      <td>".$Abb."</td>
      <td>".$Address."</td>
      <td>".$State."</td>
      <td>".$Zip."</td>
      <td>".$Country."</td>
      <td><a href = DeleteCampus.php?id=".$id." onclick=\"return confirm('Are you sure to delete Campus in id: ".$id."');\"> Delete </a> &nbsp</td>
      <td><a href = UpdateCampus.php?id=".replaceSpace($id)."&Name=".replaceSpace($Name)."&Abb=".replaceSpace($Abb)."&Address=".replaceSpace($Address)."&State=".replaceSpace($State)."&Zip=".replaceSpace($Zip)."&Country=".replaceSpace($Country)."> Update </a> &nbsp</td>
      </tr>";
    }
  }

  $conn->close();
}
?>
<!DOCTYPE html>
<html lang = "en">
<head>
  <div class="menu">
    <?php include 'header.php'; ?>
    <br><br>
  </div>
</head>
<body>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <p>
      Search
      <select name="key">
        <option value="Name">Name</option>
        <option value="Abb">Abb</option>
        <option value="Address">Address</option>
        <option value="State">State</option>
        <option value="Zip">Zip</option>
        <option value="Country">Country</option>
      </select>
      Keyword: <input type="text" name="keyword">
      <input type="submit" name="submit" value="Submit">
    </p>
  </form>

  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          Result
        </div>
        <div class="panel-body">
          <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Abb</th>
                  <th>Address</th>
                  <th>State</th>
                  <th>Zip</th>
                  <th>Country</th>
                  <th>Delete</th>
                  <th>Update</th>
                </tr>
              </thead>
              <tbody>
                <?php
                populateTable();
                ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</body>
</html>
