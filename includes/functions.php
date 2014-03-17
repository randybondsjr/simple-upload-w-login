<?php 
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
    $mysqli = ConnectToDBo('wptransit');
    
    // check if the user id and password combination exist in database
    $sql = "SELECT * FROM gtfs_users WHERE username = '$user' AND password = '$pass' LIMIT 0,1";

    //if things worked
    if ($result = $mysqli->query($sql)) {
    //we need to check for results
    $row_cnt = $result->num_rows;
       //if match is equal to 1 there is a match
      if($row_cnt == 1){
        //need to clean out any errors that may exist
        unset($_SESSION['error']);
        
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
  
  function upload_file($file,$path){
    print_r($file);
    print_r($path);
    //UPLOAD A FILE, IF ONE IS PRESENT
		if($file["name"] != ''){
			#### FILE UPLOAD PROCESS START ####
			//define upload path
			//$target_path = "/var/www/apps/yak-back/uimages";
			$target_path = $path;
			
			//we want to organize these files in folders by year, check if the folder exists, if it doesn't, make it
			if(!is_dir($target_path)){
				mkdir($target_path, 0755);	
			}
			
			//clean up the spaces in the filename
			$filename = date("YmdHis");
			$filename = "$filename.jpg";
					
			//more or less, we're defining the renamed file, with folder path
			$target_path = $target_path ."/". basename($filename); 
			
			//check and see if this is a pdf, if not, DO NOT allow upload (security is bestest)
			if($_FILES['photo']['type'] == 'image/jpeg'){
				move_uploaded_file($_FILES['photo']['tmp_name'], $target_path);
		
			}
			#### FILE UPLOAD PROCESS END ####
		}
  }