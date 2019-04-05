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
if (isset($_GET["fielddo"])){
	$fielddo=$_GET["fielddo"];
} else {
	$fielddo = "";
}
// modify form fields
if ($fielddo == "adm") {

	
	echo '<h3>Form Fields for '.$formname.' Form</h3>';

	// new field form
	echo '<form name="newformfield" class="form-horizontal" method="post" action="admin.php?fielddo=insField&amp;formname='.$formname.'&amp;formid='.$formid.'">';		

	echo '<div class="table-responsive"><table class="table">
			<tr style="background-color: #eee;border: 2px solid #bbb;"><td colspan="10"><strong>Add a New Form Field</strong></td></tr>
			<tr><td>&nbsp;</td><td>Field Name</td><td>Field Order</td><td>Active on Form</td><td>Maxlength</td><td>Type</td><td>Required</td><td>Level of Access</td><td>Tooltip</td><td>&nbsp;</td></tr>';

	echo '<tr>
				<td>&nbsp;</td>
				<!--<td><input class="form-control" type="Text" name="fieldname" placeholder="Field Name" value="" required></td>-->
				<td><input class="form-control" type="text" name="fieldalias" placeholder="Field Alias" value="" required></td>';

				// get the next number for field order
				$result_nextfield = $conn->query($query_nextfield='SELECT count(*)+1 as nextfield from hs_fields where formid = '.$formid);
				if ($result_nextfield->num_rows > 0) {
					while($row_nextfield = $result_nextfield->fetch_assoc()) {
						$nextfield = $row_nextfield["nextfield"];
					}
				}
				echo '<td><input class="form-control" type="text" name="fieldorder" placeholder="Order on Form" value="'.$nextfield.'" required></td>
				<td><select class="form-control" name="showonform" required>
					<option value="Yes">Yes</option>
					<option value="No">No</option>
					</select></td>
				<td><input class="form-control" type="text" name="maxlength" placeholder="Maxlength" value="" required></td>
				<td><select class="form-control" name="type">
					<option value="Text">Text</option>
					<option value="Email">Email</option>
					<option value="Datetime">Datetime</option>
					<option value="Decimal">Decimal</option>
					<option value="Single Member List">Single Member List</option>
					<option value="Multiple Member List">Multiple Member List</option>';

				// get available lists
				$result_lists = $conn->query($query_lists = "SELECT * FROM hs_lists order by listname");
				if ($result_lists->num_rows > 0) {
					while($row_lists = $result_lists->fetch_assoc()) {
						echo '<option value="List - '.$row_lists["listname"].','.$row_lists["listid"].'">List - '.$row_lists["listname"].'</option>';
					}
				}
					echo '</select></td>
				<td><select class="form-control" name="required" required>
					<option value="Yes">Yes</option>
					<option value="No">No</option>
					</select></td>
				<td>';
			   $fieldname="accessprivs";
			   $needarray="No";
			   include 'levelofaccesslist.php';
			   echo '</td>
				<td><input type="text" class="form-control" name="tooltip" placeholder="Tooltip" value=""></td><td>&nbsp;</td></tr>
			<tr><td colspan="10"><button type="submit" name="submit" class="btn btn-default">Save New Field</button></td></tr></form>';


	echo '<tr>';

	// display details of selected form
	echo '<tr style="background-color: #eee;border: 2px solid #bbb;"><td colspan="10"><strong>Modify Form Fields Below</strong></td></tr><form id="modifyform" name="modifyform" method="post" action="admin.php?formid='.$formid.'&amp;fielddo=updField&amp;formname='.$formname.'" onSubmit="return checkNos()">'; 
	echo '<tr><td>Actions</td><td>Field Name</td><td>Order on Form</td><td>Active on Form</td><td>Maxlength</td><td>Field Type</td><td>Required Field</td><td>Level of Access</td><td>Tooltip</td></tr>';
	$result_formadm = $conn->query($query_formadm = "SELECT * FROM hs_fields, hs_forms WHERE hs_fields.formid = hs_forms.formid and hs_forms.formid ='".$formid."' ORDER BY fieldorder");
	
		if ($result_formadm->num_rows > 0) {
			echo '<input type="hidden" value="'.$result_formadm->num_rows.'" name="numrows">';
			$i = 0;
			while($row_formadm = $result_formadm->fetch_assoc()) {
				echo '<input type="hidden" name="fieldname[]" value="'.$row_formadm["fieldname"].'">';
				echo '<tr><td style="text-align:center;"><a title="Delete this Field" href="admin.php?fid='.$row_formadm["id"].'&amp;fielddo=delFields&amp;formid='.$formid.'&amp;formname='.$formname.'"><span class="glyphicon glyphicon-remove"></span></a><input type="hidden" name="id[]" value="'.$row_formadm["id"].'"></td>
					<td><input type="text" name="fieldalias[]" class="form-control" placeholder="Field Alias" value="'.$row_formadm["fieldalias"].'" required></td>
					<td><input type="text" name="fieldorder[]" class="form-control" placeholder="Field Order" value="'.$row_formadm["fieldorder"].'" required></td>
					<td>
					<select class="form-control" name="showonform[]" required>
					<option value="'.$row_formadm["showonform"].'">'.$row_formadm["showonform"].'</option>
					<option value="">--SELECT ONE--</option>
					<option value="Yes">Yes</option>
					<option value="No">No</option>
					</select>';
				echo '</td><td><input type="text" name="maxlength[]" class="form-control" value="'.$row_formadm["maxlength"].'"></td>
					<td><select class="form-control" name="type[]">';
					if (substr($row_formadm["type"],0,4) == "List") {
						$optionvalue = $row_formadm["type"].",".$row_formadm["listid"];
					} else {
						$optionvalue = $row_formadm["type"];
					}
					echo '<option value="'.$optionvalue.'">'.$row_formadm["type"].'</option>
					<option value="">--SELECT ONE--</option>
					<option value="Text">Text</option>
					<option value="Email">Email</option>
					<option value="Datetime">Datetime</option>
					<option value="Decimal">Decimal</option>
					<option value="Single Member List">Single Member List</option>
					<option value="Multiple Member List">Multiple Member List</option>';
					
					// get available lists
					$result_lists = $conn->query($query_lists = "SELECT * FROM hs_lists order by listname");
					if ($result_lists->num_rows > 0) {
						while($row_lists = $result_lists->fetch_assoc()) {
							echo '<option value="List - '.$row_lists["listname"].','.$row_lists["listid"].'">List - '.$row_lists["listname"].'</option>';
						}
					}
				echo '</select></td>
				<td>
				<select class="form-control" name="required[]" required>
					<option value="'.$row_formadm["required"].'">'.$row_formadm["required"].'</option>
					<option value="">--SELECT ONE--</option>
					<option value="Yes">Yes</option>
					<option value="No">No</option>
					</select>';
				echo '</td><td>';
				$fieldname='accessprivs';
				$needarray="Yes";
				$fieldvalue=$row_formadm["accessprivs"];
				include 'levelofaccesslist.php';
				echo '</td><td><input type="text" class="form-control" name="tooltip[]" placeholder="Tooltip" value="'.$row_formadm["tooltip"].'"></td></tr>';
				++$i;
		}

		echo '<tr><td colspan="10"><button type="submit" name="submit" class="btn btn-default">Save Changes</button>';
	}	
	echo '</table></div></form>';
}

// update selected fields
if ($fielddo == "updField") {
	$fieldname = $_POST['fieldname'];
	$fieldalias = $_POST['fieldalias'];
	$fieldorder = $_POST['fieldorder'];
	$showonform = $_POST['showonform'];
	$maxlength = $_POST['maxlength'];
	$type = $_POST['type'];
	$required = $_POST['required'];
	$accessprivs = $_POST['accessprivs'];
	$id = $_POST['id'];
	

	// get tablename
	$result_table = $conn->query($query_table = 'SELECT tablename FROM hs_forms WHERE formid = "'.$formid.'"');
	if ($result_table->num_rows > 0) {
		while($row_table = $result_table->fetch_assoc()) {
			$tablename=$row_table["tablename"];
		}
	}

	// update field details
	foreach( $id as $key => $n ) {
		// if it's a list find the list id else list id is 0
		if (substr($type[$key], 0, 4) == "List") {
			$listitems = explode ( ",", $type[$key] ); 
			$type[$key] = $listitems[0];    		// first item in list is the type
			$listid = $listitems[1];  				// second item in the list is the list id
		} else {
			$listid = 0;
		}

		// update fields table
		
		$query = 'UPDATE hs_fields SET fieldalias = "'.$fieldalias[$key].'", fieldorder = '.$fieldorder[$key].', showonform = "'.$showonform[$key].'", maxlength = '.$maxlength[$key].', type = "'.$type[$key].'", required="'.$required[$key].'", accessprivs="'.$accessprivs[$key].'", listid = '.$listid.' WHERE id = '.$n; 
		
		//modify table with new field specs
		//potential bug here with larget varchar fields > 500 char
		if ($type[$key] == "Datetime"){
			$query_updTable = "ALTER TABLE ".$tablename." MODIFY ".$fieldname[$key]." ".$type[$key];
		} elseif ($type[$key] == "Decimal") {
			$query_updTable = "ALTER TABLE ".$tablename." MODIFY ".$fieldname[$key]." decimal(11,2)";
		} else {
			$query_updTable = "ALTER TABLE ".$tablename." MODIFY ".$fieldname[$key]." VARCHAR( ".$maxlength[$key]." ) ";
		}
		//echo $query_updTable."<br>";
		$sqlupdate = $conn->query($query);
		$sqlupdate2 = $conn->query($query_updTable);
		if(!$sqlupdate or !$sqlupdate2) {
			die('Error:' . mysqli_error($conn)); 
		}	
	}
	echo '<h3>Field updated successfully!</h3><p><a href="admin.php?fielddo=adm&amp;formid='.$formid.'&amp;formname='.$formname.'">Back to Modify Form</a></p>';
}

// insert fields into form
if ($fielddo == "insField") {

	// which table are we working with?
	$result_table = $conn->query($query_table = 'SELECT tablename FROM hs_forms WHERE formid = "'.$formid.'"');
	if ($result_table->num_rows > 0) {
		while($row_table = $result_table->fetch_assoc()) {
			$tablename=$row_table["tablename"];
		}
	}
	// set target field types

	// need to figure out how to do this more eloquently
	$fieldname = str_replace(' ', '', $_POST["fieldalias"]);
	$fieldname = str_replace('-', '', $fieldname);

	// if it's a list find the list id else list id is 0
	if (substr($_POST["type"], 0, 4) == "List") {
		$listitems = explode ( ",", $_POST["type"]); 
		$_POST["type"] = $listitems[0];    		// first item in list is the type
		$listid = $listitems[1];  		// second item in the list is the list id
	} else {
		$listid = 0;
	}
	
	// add field to table
	if ($_POST["type"] == "Datetime") {
		$query_addtoTable = "ALTER TABLE ".$tablename." ADD ".$fieldname." ".$_POST["type"];
	} elseif ($_POST["type"] == "Decimal") {
		$query_addtoTable = "ALTER TABLE ".$tablename." ADD ".$fieldname." decimal(11,2)";
	} else {
		$query_addtoTable = "ALTER TABLE ".$tablename." ADD ".$fieldname." VARCHAR( ".$_POST["maxlength"]." ) ";
	}
	$sqlupdate = $conn->query($query_addtoTable);
	if(!$sqlupdate) { die('Error:' . mysqli_error($conn));} 
	
	// insert field specs into fields table
	$query_ins = 'INSERT INTO hs_fields (fieldname, fieldalias, formid, fieldorder, showonform, maxlength, type, required, tooltip, listid, accessprivs ) VALUES("'.$fieldname.'","'.$_POST["fieldalias"].'",'.$_GET["formid"].','.$_POST["fieldorder"].',"'.$_POST["showonform"].'",'.$_POST["maxlength"].',"'.$_POST["type"].'",'.$_POST["required"].',"'.$_POST["tooltip"].'",'.$listid.',"'.$_POST["accessprivs"].'")';
	$sqlupdate = $conn->query($query_ins);
	if(!$sqlupdate) {
		die('Error:' . mysqli_error($conn));
	} else {
		echo '<h3>New field added successfully!</h3><p><a href="admin.php?fielddo=adm&amp;formid='.$formid.'&amp;formname='.$formname.'">Back to Modify Form</a></p>';
	}
}

// delete selected fields from form
if ($fielddo == "delFields") {
	$fieldid = $_GET['fid'];
	// delete field from fields table
	$query_del = 'DELETE from hs_fields WHERE id = '.$fieldid;
	
	// grab tablename
	$result_getTable = $conn->query($query_gettable = 'SELECT tablename, fieldname FROM hs_forms, hs_fields where hs_forms.formid = hs_fields.formid and hs_fields.id = '.$fieldid);
	if ($result_getTable->num_rows > 0) {
		while($row_getTable = $result_getTable->fetch_assoc()) {
			$tablename = $row_getTable["tablename"];
			$fieldname = $row_getTable["fieldname"];
		}
	}

	// delete field from table
	$query_delTable = 'ALTER TABLE '.$tablename.' DROP COLUMN '.$fieldname;

	$sqlupdate = $conn->query($query_del);
	$sqlupdate2 = $conn->query($query_delTable);
	if(!$sqlupdate or !$sqlupdate2) {
		die('Error:' . mysqli_error($conn));
	} else {
		echo '<h3>Delete successful!</h3><p><a href="admin.php?fielddo=adm&amp;formid='.$formid.'&amp;formname='.$formname.'">Back to Modify Form</a></p>';
	}
}
?>