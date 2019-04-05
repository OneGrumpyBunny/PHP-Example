
<?php


  /*   $_SESSION['is_logged_in'] = 0;

   $login = query("SELECT count(*) FROM members WHERE (username = '" .($_POST['user']). "') and (password = '" .md5($_POST['pass']). "')");

        // Check username and password match

         if (mysql_num_rows($login) == 1) {
        // Set username session variable
        $_SESSION['username'] = $_POST['user'];

        // Jump to secured page
         header('Location: securedpage.php');
        }
        else {
        // Jump to login page
        header('Location:career.php');
        }








        if (!isset($_SESSION['is_logged_in'])) {
        $_SESSION['is_logged_in'] = 1;
    }

    if (!isset($_SESSION['email'])) {
        $_SESSION['email'] = $myemail;
    }
    if (!isset($_SESSION['password'])) {
        $_SESSION['password'] = $mypassword;
    }

    // Register user's name and ID
    if ((!isset($_SESSION['name'])) && (!isset($_SESSION['user_id'])))  {
        $row = mysql_fetch_assoc($login_result);
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
    } 


    
    if (!isset($_SESSION['is_logged_in'])) {
        $_SESSION['is_logged_in'] = 1;
    }

    if (!isset($_SESSION['email'])) {
        $_SESSION['email'] = $myemail;
    }
    if (!isset($_SESSION['password'])) {
        $_SESSION['password'] = $mypassword;
    }

    // Register user's name and ID
    if ((!isset($_SESSION['name'])) && (!isset($_SESSION['user_id'])))  {
        $row = mysql_fetch_assoc($login_result);
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
    }

    header("Location: ".BASE_DIR."/index.php");
*/
?>
