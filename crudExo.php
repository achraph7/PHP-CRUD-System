<?php 
      session_start();
      $mysqli = new mysqli('localhost','root','','cruddb',) or  die(mysqli_error($mysqli));
      $result = $mysqli->query("SELECT * FROM coord_utilisat") or die($mysqli->error);
      $name = '';
      $email = '';
      $update = false;
      $id = 0;
      if (isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];

        $mysqli->query("INSERT INTO coord_utilisat VALUES ('','$name', '$email')") or die($mysqli->error);
      
        $_SESSION['message'] = "RECORD HAS BEEN SAVED! ";
        $_SESSION['msg_type'] = "success";
        header("location: crudExo.php");
        exit();

      }

        
        if (isset($_GET['delete'])){
          $id = $_GET['delete'];
          $mysqli->query("DELETE FROM coord_utilisat WHERE id = $id") or die($mysqli->error);
          $_SESSION['message'] = "RECORD HAS BEEN DELETED! ";
          $_SESSION['msg_type'] = "danger";
          header("location: crudExo.php");
          exit();
        }

        if (isset($_GET['edit'])){
          $id = $_GET['edit'];
          $update = true;
          $results = $mysqli->query("SELECT * FROM coord_utilisat WHERE id = $id") or die($mysqli->error);
          if(count(array($results)) > 0){
            $row = $results->fetch_array();
            $name = $row['full_name'];
            $email = $row['email'];
          }
        }

        if(isset($_POST['update'])){
          $id = $_POST['id'];
          $name = $_POST['name'];
          $email = $_POST['email'];
          $mysqli->query("UPDATE coord_utilisat SET full_name = '$name', email = '$email' WHERE id = '$id' ") or die($mysqli->error);
          $_SESSION['message'] = "RECORD HAS BEEN UPDATED! ";
          $_SESSION['msg_type'] = "warning";
          header("location: crudExo.php");
          exit();
        }
      
?> 

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Crud system</title>
  </head>
  <body>
    <?php 
    if(isset($_SESSION['message'])):
    ?>
    <div class = "alert alert-<?=$_SESSION['msg_type']?>">
      <?php 
      echo $_SESSION['message'];
      unset($_SESSION['message']);
      ?>
      
     </div>
     <?php endif ?>

  <div class = "container">
    <form action = "" method ="POST">
      <input type="hidden" name = "id" value = <?php echo $id; ?>>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label" >Name</label>
        <input type="text" class="form-control" name="name" value= "<?php echo $name; ?>" placeholder = "Put your name">
        <div  class="form-text">put your name here</div>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" name="email" value= "<?php echo $email; ?>" placeholder = "put your mail">
        <div class="form-text">We'll never share your email with anyone else.</div>
      </div>
      <div class="form-group">
        <?php 
          if($update == true):
            ?>
            <button type="update" name="update" class="btn btn-info">Update</button>
        <?php
          else:
            ?>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        
        <?php endif; ?>

        
      </div>
    
  </form>
<br>
  </div>

  <div class = "container">
      <div class = "row justify-content-center">
        <table class = "table table-dark table-striped">
          <thead>
            <th>NAME</th>
            <th>EMAIL</th>
            <th collspan = "2">ACTION</th>
          </thead>
            <?php
              while($row = mysqli_fetch_assoc($result))
              {
                ?>
              <tr>
                <td><?php echo $row['full_name']?></td>
                <td><?php echo $row['email']?></td>
                <td>
                  <a href="crudExo.php?edit=<?php echo $row['id']; ?>" class ="btn btn-info">Edit</a>
                  <a href="crudExo.php?delete=<?php echo $row['id']; ?>" class ="btn btn-danger">Delete</a> 
              </td>
              </tr> 
              
              
              
            <?php 
              }
           ?>
        </table>

        
      </div>
  </div>
  <body>
  </html>