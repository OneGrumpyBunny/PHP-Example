<?php

    $loginuser = $_POST['loginuser'];
    $loginpass = $_POST['loginpass'];
    
    /*$hashedpass = password_hash($password, PASSWORD_DEFAULT); */
    /*$correct = password_verify($unecnrypted_password, $row['encrypted_password']); */

    
    $result_login = $conn->query($query_login = "SELECT accessprivs, operationalstatus FROM hs_users WHERE countyID = '".$loginuser."' and userpass = '".$loginpass."'");
    
    if ($result_login->num_rows > 0) {
        
       // session_start();
        $_SESSION["user"] = $loginuser;
        $_SESSION["is_logged_in"] = 1;
        
        while($row = $result_login->fetch_assoc()) {
           

            $_SESSION["accessprivs"] =  $row["accessprivs"];
            //$_SESSION['websitestatus'] = $row["websitestatus"]; // can access website
            $_SESSION['operationalstatus'] = $row["operationalstatus"]; // active or inactive
            //$_SESSION['is_member_admin'] = $row["ismemberadmin"]; // membership admin
        }
        
    } else {
        $loginfailedmsg = '<div class="acctMng" style="border:0;"><p class="login_error_msg">Invalid username or password! Please try again.</p></div>'; 
        $_SESSION["is_logged_in"] = 0;
        /*echo'<script type="text/javascript">
            $(document).ready(function(){
            $("#myModal").modal("show");
            });
            </script>';*/
    }
    
    
?>
