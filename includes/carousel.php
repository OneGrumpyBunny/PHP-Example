<div class="row">
	<!-- carousel -->  

<?php
//include 'dbconn.php';

//query database for admin site selections
//$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}

$result_carousel = $conn->query($query_carousel = "SELECT hs_attribute as carousel_order FROM hs_globals WHERE hs_label = 'carousel_img' ORDER by hs_attribute");

?>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
	  <!-- Indicators -->
	  <ol class="carousel-indicators">
		<?php	
		if ($result_carousel->num_rows > 0) {
			$count1 = 0;
			while($row_carousel = $result_carousel->fetch_assoc()) {
				echo '<li data-target="#carousel-example-generic" data-wrap="yes" data-slide-to="'.$row_carousel["carousel_order"].'"';
				if ($count1 == 0) {
					echo ' class="active"';
				}
				echo '></li>';
			$count1++;	
			}

		}
		?>
		</ol>
	  <!-- Wrapper for slides -->
	  <div class="carousel-inner" role="listbox">

		<?php
		$result_carousel = $conn->query($query_carousel = "SELECT hs_value as carousel_img FROM hs_globals WHERE hs_label = 'carousel_img' ORDER by hs_attribute");

		if ($result_carousel->num_rows > 0) {
			$count2 = 0;
			while($row_carousel = $result_carousel->fetch_assoc()) {
				echo '<div class="item';
				if ($count2 == 0) {
					echo ' active';
				  }
				  echo '">
			      <img src="'.$globals["IMG_DIR"].$row_carousel["carousel_img"].'"  width="100%" alt="...">
						<div class="carousel-caption">
				      	<!--<h3>Action shot!</h3>
				      	<p>Photo of fire fighting</p>-->
				        </div>
				    </div>
			    ';
			    $count2++;
			    }
			}
		
		//$conn->close();	
		?>  	
	    
	  </div>

	  <!-- Controls -->
	  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>
</div><!-- row -->