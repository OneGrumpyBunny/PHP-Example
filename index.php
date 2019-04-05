<?php include 'hs_wrap.php';?>

<!--  container row -->
<div class="container">
<div class="row">
	<div class="col-lg-8 main-content">

		<?php 
		
		if (isset($_GET['page'])) {
			$query1 = "SELECT page_title, page_content, page_param, content_type FROM hs_pages WHERE page_id = ".$_GET['page'];
		} else {
			$query1 = "SELECT page_title, page_content, page_param, content_type FROM hs_pages WHERE content_type= 'featured page'";
		}
		//echo $query1;
		// requesting a specific page? if not, show featured page (i.e. home page)
		
		//if (!empty($pageid))  {

			//if page selected - pull requested page
			//$result_featured = $conn->query($query1 = "SELECT page_title, page_content, featured_page FROM hs_pages WHERE page_ID = $pageid AND content_type in ('Page')");
			$result_featured = $conn->query($query1);
			if ($result_featured->num_rows > 0) {

		    	while($row_featured = $result_featured->fetch_assoc()) {
		    		echo "<h1>".$row_featured["page_title"]."</h1>";
		    		
					if ($row_featured["content_type"] == "Member List") {
						echo "<p>".$row_featured["page_content"]."</p>";
						include $globals["INCL_DIR"].'members.php';
					} else {
						echo $row_featured["page_content"];
					}
	        	}
	    	}
	    	else {
	        	echo "<p>Error retrieving page!</p>";
	    	}
		//}

	    

	?>

	</div> <!-- col 8 -->

	<div class="col-lg-4 sidebar">

	<?php include $globals["INCL_DIR"].'sidebar.php';?>

	</div> <!-- col 4-->
</div> <!-- row -->
</div> <!-- container -->

<?php include $globals["INCL_DIR"].'footer.php';?>