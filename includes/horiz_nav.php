<?php include $globals["INCL_DIR"].'loginmodal.php'; ?>

<nav class="navbar navbar-inverse">
<div class="container-fluid">
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
			<li>
				<div class="logosm" style="display: none;"><img src="http://www.hydrantsoft.com/sites/dev/bvfco11/media/NewPatch-small-transparent.png" data-pin-nopin="true">
					<p style="max-width: 175px;">
					<?php if (isset($_SESSION["is_logged_in"]) and $_SESSION["is_logged_in"] == 1) {
						if ($_SESSION['accessprivs'] == "Admin"){
							echo '<a href="admin.html"><span class="glyphicon glyphicon-cog"></span></a> ';
						}
						echo '<em> '.$rankname.' </em><br>';
					}
					echo '<em><span max-width="100px">'.$globals["SITE_TITLE"].'</span></em>';
					?>
					</p>
				</div>
			</li>
		<?php 

		if ($_SESSION["is_logged_in"] == 1) {
			$query = "SELECT menu_label, menu_position, menu_id, menu_url FROM hs_menus where menu_group in ('all','member') and menu_id <> 9 ORDER BY menu_position";
		} else {
			$query = "SELECT menu_label, menu_position, menu_id, menu_url FROM hs_menus where menu_group = 'all' and menu_id <> 9 ORDER BY menu_position";
		}

		$result_nav = $conn->query($query);
		
		if ($result_nav->num_rows > 0) {
        	while($row = $result_nav->fetch_array()) { 
				$query2 = "SELECT page_url, page_title, parent_menu, menu_order, displayaccess, formactive, formid FROM hs_pages LEFT JOIN hs_forms ON hs_pages.page_id = hs_forms.page_id WHERE page_status <>  'Publish-hold' AND parent_menu = ".$row["menu_id"]." order by menu_order";

        		$result2_nav = $conn->query($query2);
        		
        		if ($result2_nav->num_rows > 0) {

        			echo "<li class='dropdown'><a href='index.php' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>".$row["menu_label"]."<span class='caret'></span></a>";
        			echo "<ul class='dropdown-menu'>";

        			while($row2 = $result2_nav->fetch_array()) {
						if (($row["menu_id"] != 8) or ($row["menu_id"] == 8 and $row2["formactive"] == 1 and $row2["displayaccess"] == "Member")) {
		            		echo "<li><a href='".$row2["page_url"]."'>".$row2["page_title"]."</a></li>";
						}
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
      </ul> <!-- nav -->
	</div> <!--navbar collapse -->
  </div> <!-- navbar-header-->
</div><!-- container-fluid -->
</nav>
</header>