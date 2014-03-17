<?php 
  start_session();
  //http://css-tricks.com/snippets/php/login-function/
  // function to escape data and strip tags
  function safestrip($string){
         $string = strip_tags($string);
         $string = mysql_real_escape_string($string);
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
  
   //call safestrip function
   $user = safestrip($username);
   $pass = safestrip($password);
  
   //convert password to md5
   $pass = md5($pass);
  
    // check if the user id and password combination exist in database
    $sql = mysql_query("SELECT * FROM table WHERE username = '$user' AND password = '$pass'")or die(mysql_error());
  
    //if match is equal to 1 there is a match
    if (mysql_num_rows($sql) == 1) {
  
                            //set session
                            $_SESSION['authorized'] = true;
  
                            // reload the page
                           $_SESSION['success'] = 'Login Successful';
                           header('Location: ./index.php');
                           exit;
  
  
     } else {
                 // login failed save error to a session
                 $_SESSION['error'] = 'Sorry, wrong username or password';
    }
  }
  //END css-tricks.com snippet
?>