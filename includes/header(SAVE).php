<!DOCTYPE html>

<html class=" js csstransforms csstransforms3d csstransitions" lang="en">
<head> 
<meta charset=utf-8> 
<meta content="IE=edge" http-equiv=X-UA-Compatible> 
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php echo "<title>".$globals["SITE_TITLE"]."</title>" ?>
<link rel='stylesheet' href='css/normalize.css' type='text/css' media='all' />
<link rel='stylesheet' href='css/bootstrap.min.css' type='text/css' media='all' />
<link rel='stylesheet' href='css/bootstrap-theme.min.css' type='text/css' media='all' />
<link rel='stylesheet' href='css/jquery.datetimepicker.min.css' type='text/css' media='all' />
<!--<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">-->
<link rel='stylesheet' href='css/custom.css' type='text/css' media='all' />
<script type='text/javascript' src='js/moment.js'></script>
<script type='text/javascript' src='js/jquery.min.js'></script>
<script type='text/javascript' src='js/bootstrap.min.js'></script>
<script type='text/javascript' src='js/jquery.datetimepicker.full.min.js'></script>
<script>
    $( document ).ready(function(){
  $('.logosm').hide();
  $('.membersm').hide();
});
                    
  $(window).scroll(function(){
    if ($(window).scrollTop() >= 300) {
      $('nav').addClass('fixed-header');
      $('.logosm').show();
      $('.membersm').show();
    }
    
    else {
       $('nav').removeClass('fixed-header');
      $('.logosm').hide();
      $('.membersm').hide();
      
    }
});
</script>
</head>
<body>
 
<header>
  <div class="header-banner">
    <?php echo '<a href="index.php"><img src="'.$globals["IMG_DIR"].$globals["BADGE_IMG"].'" class="Logo"></a>'; 
    	  if (isset($_POST["login_submit"])) {
			include 'login.php';
			}

			if (isset($_SESSION["is_logged_in"]) and $_SESSION["is_logged_in"] == 1) {
				$result_user = $conn->query($query_user = "SELECT displayname, photo, countyID, operationalrank FROM hs_users WHERE countyID = '".$_SESSION["user"]."'");
			
				if ($result_user->num_rows > 0) {
					while($row_user = $result_user->fetch_assoc()) {
						echo '<div class="membercard">
							<h4>'.$row_user["operationalrank"].' '.$row_user["displayname"].'</h4>
							<div class="row">
							<div class="col-sm-6">
							<img class="memberactionimg" src="'.$globals["IMG_DIR"].'members/'.$row_user["photo"].'" data-pin-nopin="true">
							</div>
							<div class="col-sm-6">';
							if ($_SESSION["accessprivs"] == 'Admin') {
								echo '<p><a href="'.$globals["BASE_URL"].'admin.php">Admin Home</a></p><p><a href="'.$globals["BASE_URL"].'index.php">Website Home</a></p>';
							}
								echo '<p>Manage Account</p></div></div> <!-- row --></div></div> <!-- header banner -->';
					}
				}
			} else {
			echo $loginfailedmsg;
			}
		?>
	</div>	  
	
</div><!-- row -->

