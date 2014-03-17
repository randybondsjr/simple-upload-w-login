<?php 
  session_start();
  
  // function to escape data and strip tags
  function safestrip($string){
         $string = strip_tags($string);
         $string = filter_var($string, FILTER_SANITIZE_STRING);
         return $string;
  }
  
  //function to show any messages
  function messages() {
     $message = '';
     if($_SESSION['success'] != '') {
         $message = '<span class="success" id="message">'.$_SESSION['success'].'</span>';
         $_SESSION['success'] = '';
     }
     if($_SESSION['error'] != '') {
         $message = '<span class="error" id="message">'.$_SESSION['error'].'</span>';
         $_SESSION['error'] = '';
     }
     return $message;
  }
  
  // log user in function
  function login($username, $password){
    //login error
    $login_error = "Sorry, wrong username or password";
    
    //call safestrip function
    $user = safestrip($username);
    $pass = safestrip($password);
    
    //convert password to md5
    $pass = md5($pass);
    //connect to the db using predefined function
    $mysqli = ConnectToDBo('db');
    
    // check if the user id and password combination exist in database
    $sql = "SELECT * FROM table WHERE username = '$user' AND password = '$pass' LIMIT 0,1";
    //if things worked
    if ($result = $mysqli->query($sql)) {
    //we need to check for results
    $row_cnt = $result->num_rows;
       //if match is equal to 1 there is a match
      if($row_cnt == 1){
        //set session
        $_SESSION['authorized'] = true;
        
        // reload the page
        $_SESSION['success'] = 'Login Successful';
        header('Location: ./index.php');
        exit;
      }else{
        //no results need an error
        $_SESSION['error'] = $login_error;
      }
      //clean up the result set
      $result->free();
    }else{
      // login failed save error to a session
      $_SESSION['error'] = $login_error;
    }
  }
?>