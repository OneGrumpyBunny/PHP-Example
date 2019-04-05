
<?php include $globals["INCL_DIR"].'loginmodal.php'; ?>
<?php include $globals["INCL_DIR"].'regmodal.php'; ?>


	<div class="row">
	<!-- hamburger menu (visible only on small screens) -->

	<nav class="navbar navbar-inverse" style="border-radius:0px;">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar" aria-expanded="false" style="float:left;">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	    </div>

	    <!-- full size nav bar (visible only on larger screens) --> 
		<div class="navbar-collapse collapse" id="bs-navbar" aria-expanded="true" style="">
		  <ul class="nav navbar-nav">
	        <li class="active"><a href="index.php">Home <span class="sr-only">(current)</span></a></li>

		<?php 

		if ($_SESSION["is_logged_in"] == 1) {
			$query = "SELECT menu_label, menu_position, menu_id, menu_url FROM hs_menus where menu_group in ('all','member') and menu_id <> 9 ORDER BY menu_position";
		} else {
			$query = "SELECT menu_label, menu_position, menu_id, menu_url FROM hs_menus where menu_group = 'all' and menu_id <> 9 ORDER BY menu_position";
		}

		$result_nav = $conn->query($query);
		
		if ($result_nav->num_rows > 0) {
        	while($row = $result_nav->fetch_array()) { 
       			
       			$query2 = "SELECT page_url, page_title, parent_menu, menu_order, displayaccess FROM hs_pages,hs_forms WHERE hs_pages.page_id = hs_forms.page_id and hs_forms.formactive = 1 and hs_forms.displayaccess = 'Member' and page_status <> 'Publish-hold' and parent_menu = ".$row["menu_id"]." order by menu_order";
        		$result2_nav = $conn->query($query2);
        		
        		if ($result2_nav->num_rows > 0) {

        			echo "<li class='dropdown'><a href='index.php' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>".$row["menu_label"]."<span class='caret'></span></a>";
        			echo "<ul class='dropdown-menu'>";

        			while($row2 = $result2_nav->fetch_array()) {
		            	echo "<li><a href='".$row2["page_url"]."'>".$row2["page_title"]."</a></li>";
        			}
        			echo "</ul>";
        			echo "</li>";

        		} else {
        			
        				echo "<li><a href='".$row["menu_url"]."'>".$row["menu_label"]."</a></li>";
        		}
        		
        	}
    	}

	    if ($_SESSION["is_logged_in"] == 0) {
	    	echo '<li><a href="#" data-toggle="modal" data-target="#myModal">Member Login</a></li>';
	    }
		?>
	      
          </ul>
    	</div><!-- navbar collapse -->
	</div> <!-- container-fluid -->
</nav> 
</div> <!-- row -->