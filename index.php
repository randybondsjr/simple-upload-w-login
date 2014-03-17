<?php 
  session_start();
  require("../includes/functions.php");
  require("./includes/functions.php");

  
  if(isset($_POST["username"]) && $_POST["username"] != ''){
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    login($username, $password);
  }
  print_r($_SESSION);
?>
<!doctype html>
<html>
<head>
  <title>Upload</title>
</head>
<body>
  <form role="form" method="POST" action="./">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</body>
</html>