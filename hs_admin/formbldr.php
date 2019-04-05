<?php 
// membership form
// which form are we doing?
if (isset($_GET["formid"])) {
	$formid = $_GET["formid"]; 
} else {
	$formid = "";
}

if (isset($_GET["formname"])) {
	$formname = $_GET["formname"];
} else {
	$formname = "";
}

// which function are we doing?
if (isset($_GET["formdo"])){
	$formdo=$_GET["formdo"];
} else {
	$formdo = "";
}

// no parameters means form list with options
if ($formdo == "build") {
		 echo '<h3>Form Builder</h3><div class="table-responsive"><table class="table">
		 		<form name="newformfield" class="form-horizontal" method="post" action="admin.php?formdo=insForm">';
		 
		 echo '<tr style="background-color: #eee;border: 2px solid #bbb;"><td colspan="7"><strong>Add New Form</strong></td></tr>
		 <tr><td>&nbsp;</td>
		 <td>Form Name</td>
		 <td>Form Description</td>
		 <td>View Form Access</td>
		 <td>Add Form Access</td>
		 <td>Edit Form Access</td>
		 <td>Delete Form Access</td></tr>';
		 
		 // new form
		 echo '<tr>
		 	   <td>&nbsp;</td><td><input class="form-control" type="text" placeholder="Form Name" name="formname" value="" required></td>
			   <td><input class="form-control" placeholder="Form Description" type="text" name="formdesc" value="" required></td>
			   <td>';
			   $fieldname="displayaccess";
			   include 'levelofaccesslist.php';
			   echo '</td><td>';
			   $fieldname="useformaccess";
			   include 'levelofaccesslist.php';
			   echo '</td><td>';
			   $fieldname="changeformaccess";
			   include 'levelofaccesslist.php';
			   echo '</td><td>';
			   $fieldnmame="deleteformaccess";
			   include 'levelofaccesslist.php';
			   echo '</td></tr>';

		 echo '<tr><td colspan="7"><button type="submit" name="insForm" class="btn btn-default">Save New Form</button></form></td></tr>';

		 echo '<tr style="background-color: #eee;border: 2px solid #bbb;"><td colspan="7"><strong>Modify Forms Below</strong></td></tr>';

		 echo '<tr><form name="updateForm" method="Post" action="admin.php?formdo=updForm"><td>Actions</td><td>Form Name</td><td>Form Description</td><td>View Form Access</td><td>Add Form Access</td><td>Edit Form Access</td><td>Delete Form Access</td></tr>';
		 
		 $result_forms = $conn->query($query_forms = "SELECT page_id, formname, formdesc, formid, displayaccess, useformaccess, changeformaccess, deleteformaccess FROM `hs_forms` WHERE formactive = 1 ORDER by formname");
		 	if ($result_forms->num_rows > 0) {
				while($row_forms = $result_forms->fetch_assoc()) {

					echo '<tr><td>';

					// action button - edit fields
					echo '<a title="Edit Fields" href="admin.php?fielddo=adm&amp;formid='.$row_forms["formid"].'&amp;formname='.$row_forms["formname"].'"><span class="glyphicon glyphicon-th-list"></span></a> ';
					
					// action button - edit form details 
					//echo '<a title="Edit Form Details" href="admin.php?formdo=updForm&amp;form='.$row_forms["formname"].'"><span class="glyphicon glyphicon-pencil"></span></a> '; 
					
					// action button - delete form 
					echo '<a title="Delete Form" href="admin.php?formdo=delForm&amp;formid='.$row_forms["formid"].'&amp;formname='.$row_forms["formname"].'"><span class="glyphicon glyphicon-remove"></span></a></td>
						  <td><input type="hidden" name="page_id[]" value="'.$row_forms["page_id"].'">
						  <input type="hidden" name="formid[]" value="'.$row_forms["formid"].'">
						  <input class="form-control" type="text" name="formname[]" value="'.$row_forms["formname"].'"></a></td>
						  <td><input class="form-control" type="text" name="formdesc[]" value="'.$row_forms["formdesc"].'"></td>
						  <td>';
			   			  $fieldname='displayaccess[]';
						  $fieldvalue=$row_forms["displayaccess"];
						  include 'levelofaccesslist.php';
						  echo '</td><td>';
						  $fieldname='useformaccess[]';
						  $fieldvalue=$row_forms["useformaccess"];
						  include 'levelofaccesslist.php';
						  echo '</td><td>';
						  $fieldname='changeformaccess[]';
						  $fieldvalue=$row_forms["changeformaccess"];
						  include 'levelofaccesslist.php';
						  echo '</td><td>';
						  $fieldname='deleteformaccess[]';
						  $fieldvalue=$row_forms["deleteformaccess"];
						  include 'levelofaccesslist.php';
						  echo '</td></tr>';
				}						
			} 
			echo '<tr><td><button type="submit" name="updForm" class="btn btn-default">Save Changes</button></td></tr></form></table></div>';

		/*<a href="admin.php?form='.$row_forms["formname"].'">'.$row_forms["formname"].'</a>*/	
		//echo '<p>Create a new form</p></div>';

}

// insert new form
if (isset($_POST['insForm']) and $formdo == "insForm") {	
	// get next number in hs_pages
	$result_nextnum = $conn->query($query_nextnum = 'SELECT max( hs_pages.page_id ) +1 AS nextnum, (SELECT max( menu_order ) FROM hs_pages WHERE parent_menu =8) as nextmenu  FROM hs_pages ORDER BY page_id');
	if ($result_nextnum->num_rows > 0) {
		while($row_nextnum = $result_nextnum->fetch_assoc()) {
			$nextnum = $row_nextnum["nextnum"];
			if ($row_nextnum["nextmenu"] == "") {
				$nextmenu = 1;
			} else {
				$nextmenu = $row_nextnum["nextmenu"];
			}
		}
	}
	
	$tablename = "hs_".str_replace(' ', '', $_POST["formname"]);

	// tack on suffix to insure unique tablename
	function generateRandom($min = 10000, $max = 99999) {
		if (function_exists('random_int')):
			return random_int($min, $max); // more secure
		elseif (function_exists('mt_rand')):
			return mt_rand($min, $max); // faster
		endif;
		return rand($min, $max); // old
	}

	$random_table_suffix = generateRandom();
	$tablename = $tablename.$random_table_suffix;

	// create table to hold the new form data
	$query_insTable = "CREATE TABLE ".$tablename." (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,regdate TIMESTAMP)";
	$sqlupdate3 = $conn->query($query_insTable);
	
	// insert form details into forms table
	$query_ins = 'INSERT INTO hs_forms (formname, formdesc, tablename, page_id, formactive, displayaccess, useformaccess, changeformaccess, deleteformaccess) VALUES ("'.$_POST["formname"].'","'.$_POST["formdesc"].'","'.$tablename.'",'.$nextnum.',1,"'.$_POST["displayaccess"].'","'.$_POST["useformaccess"].'","'.$_POST["changeformaccess"].'","'.$_POST["deleteformaccess"].'")';
	$sqlupdate = $conn->query($query_ins);

	$newformid = $conn->insert_id;
	
	// insert form link in pages table (for member's area drop down menu in nav bar)
	$urlformname = urlencode($_POST["formname"]);
	$query_insPage = 'INSERT INTO hs_pages (page_title, content_type, page_url, page_status, menu_order, parent_menu, page_content, pinged) VALUES ("'.$_POST["formname"].'","Page","admin.php?formid='.$newformid.'&recorddo=listrecords&formname='.$urlformname.'","Publish",'.$nextmenu.', 8," "," ")';
	$sqlupdate2 = $conn->query($query_insPage);
	
	if(!$sqlupdate or !$sqlupdate2 or !$sqlupdate) {
		die('Error:' . mysqli_error($conn));
	} else {
		echo '<h3>Form added successfully!</h3><p><a href="admin.php?fielddo=adm&formid='.$newformid.'&formname='.$_POST["formname"].'">Add fields to this form</a></p>';
		//header ("Location: admin.php?fielddo=adm&formid=".$newformid."&formname=".$_POST["formname"]."&msg=Form+added+successfully!");
		
	}
}

// update form details
if ($formdo == "updForm") {

	$formname = $_POST['formname'];
	$formdesc = $_POST['formdesc'];
	$page_id = $_POST["page_id"];
	$formid = $_POST['formid'];
	$displayaccess = $_POST['displayaccess'];
	$useformaccess = $_POST['useformaccess'];
	$changeformaccess = $_POST['changeformaccess'];
	$deleteformaccess = $_POST['deleteformaccess'];
	
	// update field details
	foreach( $formid as $key => $n ) {
		$urlformname = urlencode($formname[$key]);
		// update fields table
		$query = 'UPDATE hs_forms SET formname = "'.$formname[$key].'", formdesc = "'.$formdesc[$key].'", displayaccess = "'.$displayaccess[$key].'", useformaccess = "'.$useformaccess[$key].'", changeformaccess = "'.$changeformaccess[$key].'", deleteformaccess = "'.$deleteformaccess[$key].'" WHERE formid = '.$n;
		$query_updPage = 'UPDATE hs_pages SET page_title = "'.$formname[$key].'", page_url="admin.php?formid='.$formid[$key].'&recorddo=listrecords&formname='.$urlformname.'" WHERE page_id = '.$page_id[$key];
		
		$sqlupdate = $conn->query($query);
		$sqlupdate2 = $conn->query($query_updPage);
		if(!$sqlupdate or !$sqlupdate2) {
			die('Error:' . mysqli_error($conn)); 
		} 

	}
	echo '<h3>Form details updated successfully!</h3><p><a href="admin.php?formdo=build">Back to Form Builder</a></p>';
}
// delete form
if ($formdo == "delForm") {

	// get tablename
	$result_queryTable = $conn->query($queryTable = 'SELECT tablename from hs_forms where formid = '.$formid);
	if ($result_queryTable->num_rows > 0) {
		while($row_queryTable = $result_queryTable->fetch_assoc()) {
			$tablename = $row_queryTable["tablename"];
		}
	}

	// deactivate form in forms table
	$query_del = 'UPDATE hs_forms SET formactive = 0 WHERE formid = '.$formid;
	
	// rename associated data table to "tablename(DEL)"
	$query_table = 'RENAME TABLE  `'.$tablename.'` TO `'.$tablename.'(DEL)`';

	echo $query_table.'<br>';
	$sqlupdate = $conn->query($query_del);
	$sqlupdate2 = $conn->query($query_del);
	if(!$sqlupdate or !$sqlupdate2) {
		die('Error:' . mysqli_error($conn)); 
	} 
	echo '<h3>Form deleted successfully!</h3><p><a href="admin.php?formdo=build&amp;formname='.$formname.'">Back to Form Builder</a></p>';
}
?>