<!-- admin screen -->
<style>
.glyphicon {padding:5px;border: 1px solid #ccc}
</style>

<nav class="navbar navbar-inverse">
<div class="container-fluid">
<div class="navbar-header">
  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar" aria-expanded="false" style="float:left;">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
  <div class="navbar-collapse collapse" id="bs-navbar" aria-expanded="true" style="">
		  
        <ul class="nav navbar-nav">
          <li>
              <div class="logosm" style="display: none;"><img src="http://www.hydrantsoft.com/sites/dev/bvfco11/prototypes/media/NewPatch-small-transparent.png" data-pin-nopin="true">
                <p style="max-width: 175px;">
								<?php if (isset($_SESSION["is_logged_in"]) and $_SESSION["is_logged_in"] == 1) {
									if ($_SESSION['accessprivs'] == "Admin"){
										echo '<a href="admin.html"><span class="glyphicon glyphicon-cog" style="border:none;"></span></a> ';
									}
									echo '<em> '.$rankname.' </em><br>';
								}
								echo '<em><span max-width="100px">'.$globals["SITE_TITLE"].'</span></em>';
								?>
								</p>
            	</div>
          </li>
          <li class="dropdown"><a href='/' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Forms<span class='caret'></span></a>
            
				<?php
				if ($_SESSION["accessprivs"] ==  "Admin") {
					
					// forms admin - list forms for modification
					$result_forms = $conn->query($query_forms = "SELECT formid, formname FROM `hs_forms` WHERE formactive = 1 ORDER by formname");
					if ($result_forms->num_rows > 0) {
						echo '<ul class="dropdown-menu">
						<li><a href="admin.php?formid=&amp;formdo=build">Form Builder</a></li>';
						while($row_forms = $result_forms->fetch_assoc()) {
							echo '<li><a href="admin.php?formid='.$row_forms["formid"].'&amp;recorddo=insRecord&amp;formname='.$row_forms["formname"].'">'.$row_forms["formname"].'</a></li>';
						}
						echo '</ul>';
					}
				}
				?>

			</li>
			 <li class="dropdown"><a href='/' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Lists<span class='caret'></span></a>
            <?php 
				if ($_SESSION["accessprivs"] ==  "Admin") {
					echo '<ul class="dropdown-menu">
					<li><a href="admin.php?formid=&amp;listdo=build">List Builder</li>';
					//lists admin - list available defined lists to use in forms
					$result_lists = $conn->query($query_lists ="SELECT listname, listid FROM hs_lists ORDER by listname");
					if ($result_lists->num_rows > 0) {
						while ($row_lists = $result_lists->fetch_assoc()) {
							echo '<li><a href="admin.php?listid='.$row_lists["listid"].'&amp;listdo=adm&amp;listname='.$row_lists["listname"].'">'.$row_lists["listname"].'</a></li>';
						}
						echo '</ul>';
					}
				}
			?>

			</li>		
		  <li class="dropdown"><a href='/' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Reports<span class='caret'></span></a>
		  <?php
				if ($_SESSION["accessprivs"] ==  "Admin") {
					echo '<ul class="dropdown-menu">';
					 // records admin - list available forms to insert a record
					$result_forms = $conn->query($query_forms = "SELECT formid, formname FROM `hs_forms` WHERE formactive = 1 ORDER by formname");
					if ($result_forms->num_rows > 0) {
						while($row_forms = $result_forms->fetch_assoc()) {

							echo '<li><a href="admin.php?formid='.$row_forms["formid"].'&amp;recorddo=listrecords&amp;formname='.$row_forms["formname"].'">'.$row_forms["formname"].'</a></li>';
						}
					echo '</ul>';
					}
				}
			?>
          </li>
          <li class="dropdown"><a href='/' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Communications<span class='caret'></span></a>
            <ul class='dropdown-menu'>
                <li><a href="#">Email Builder</a></li>
                <li><a href="#">Menu Item</a></li>
                <li><a href="#">Menu Item</a></li>
                <li><a href="#">Menu Item</a></li>
            </ul>
          </li>
					<li class="dropdown"><a href='/' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Pages<span class='caret'></span></a>
            <ul class='dropdown-menu'>
                <li><a href="#">Page Builder</a></li>
                <li><a href="#">Menu Item</a></li>
                <li><a href="#">Menu Item</a></li>
                <li><a href="#">Menu Item</a></li>
            </ul>
          </li>
        </ul> <!-- nav -->
    </div> <!--navbar collapse -->
  </div> <!-- navbar-header-->
</div><!-- container-fluid -->
</nav>
</header>

<div class="container">
	<div class="col-lg-12 admin-content">
		<?php 
			
			// for form modifications
			if (isset($_GET["formdo"]) and !$_GET["formdo"] == "") {
				include $globals["ADMIN_DIR"].'formbldr.php';
			} elseif (isset($_GET["fielddo"]) and !$_GET["fielddo"] == "") {
			// for field modifications
				include $globals["ADMIN_DIR"].'fieldbldr.php';
			} elseif (isset($_GET["recorddo"])and !$_GET["recorddo"] == "") {
			// for record modifications
				include $globals["ADMIN_DIR"].'recordbldr.php';
			} elseif (isset($_GET["listdo"])and !$_GET["listdo"] == "") { 
			// for list modifications
				include $globals["ADMIN_DIR"].'listbldr.php';
			} else {
				include $globals["ADMIN_DIR"].'instruct.php';
			}
			
		?>
		
	</div> <!-- col 12 -->
</div> <!-- container -->
</div> <!-- row -->


<?php include $globals["INCL_DIR"].'footer.php';?>