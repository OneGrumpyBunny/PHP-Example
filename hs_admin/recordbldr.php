<?php 

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
if (isset($_GET["recorddo"])){
	$recorddo=$_GET["recorddo"];
} else {
	$recorddo = "";
}

// list records
if ($recorddo == "listrecords") {

	
	echo '<h3>'.$formname.'</h3>
			<div class="table-responsive"><table class="table"><tr><td colspan="7"><a href="admin.php?formid='.$formid.'&amp;recorddo=insRecord&amp;formname='.$formname.'">Add new record</a></td></tr>';

	$result_fields = $conn->query($query_fields = "SELECT fieldname,fieldalias, tablename FROM hs_fields, hs_forms WHERE hs_fields.formid = hs_forms.formid and hs_forms.formid ='".$formid."' and showonform = 'Yes' and type <> 'Password' ORDER BY fieldorder");
	$fieldsforselect = "";
	if ($result_fields->num_rows > 0) {
		$i=1;
		echo '<tr><td>Actions</td>';
		while($row_fields = $result_fields->fetch_assoc()) {
				$fieldlist[$i] = $row_fields["fieldname"];
				$tablename=$row_fields["tablename"];
				echo '<td>'.$row_fields["fieldalias"].'</td>';

				// build select query
				if ($i == 1) {
					$fieldsforselect = 'SELECT id, '.$row_fields["fieldname"];
				} else {
					$fieldsforselect = $fieldsforselect.','.$row_fields["fieldname"];
				}
		++$i;
		}
		$fieldsforselect = $fieldsforselect.' FROM '.$tablename;
		echo '</tr>';
		// get records
		$result_form = $conn->query($query_form = $fieldsforselect);
		
		if (!$result_form) {

		} else {
			
			while($row_form = $result_form->fetch_assoc()) {
				echo '<tr><td><a title="Edit this Record" href="admin.php?formid='.$formid.'&amp;recorddo=updRecord&amp;id='.$row_form["id"].'&amp;formname='.$formname.'"><span class="glyphicon glyphicon-pencil"></span></a> <a title="Delete this Record" href="admin.php?formid='.$formid.'&amp;recorddo=delRecord&amp;id='.$row_form["id"].'&amp;formname='.$formname.'"><span class="glyphicon glyphicon-remove"></span></a></td>';
				
				$j = 1;
				// loop through query results and build output
				while( $j < $i ) {
					$thisfield = $fieldlist[$j];
					echo '<td>'.$row_form["$thisfield"].'</td>';
					$j++;	
				}
				echo '</tr>';
			}
			
		}
	}
	echo '</table></div>';
}

// show form to insert a new record
if ($recorddo == "insRecord") {
	
	echo "<script type='text/javascript'>$(document).ready(function () {";
	$result_dates = $conn->query($query_dates = 'SELECT hs_fields.fieldname, type from hs_fields, hs_forms WHERE hs_fields.formid = hs_forms.formid and hs_forms.formid = '.$formid.' and type in ("Datetime","Multiple Member List")');
	if ($result_dates->num_rows > 0) {
		$i=1;
		while($row_dates = $result_dates->fetch_assoc()){
			// get JS set up for date pickers
			if ($row_dates["type"] == "Datetime") {
				echo "$('#".$row_dates["fieldname"]."').datetimepicker();";
			}
			if ($row_dates["type"] == "Multiple Member List") {
			// get JS set up for multiple select fields
				
					echo "$('#".$row_dates["fieldname"]."').select2({
							placeholder: 'Select an option',
							allowClear: true
						});";				
			}
			$i++;			
		}
	}
	
	echo "});</script>";
	


	echo "<h3>".$formname." Form</h3>";
	$result_fields = $conn->query($query_fields = "SELECT hs_fields.id AS fid, hs_fields.* , hs_forms.* FROM hs_fields, hs_forms WHERE hs_fields.formid = hs_forms.formid and hs_forms.formid ='".$formid."' and showonform = 'Yes' ORDER BY fieldorder");
	
	if ($result_fields->num_rows > 0) {
		echo '<form class="form-horizontal" method="post" action="admin.php?formid='.$formid.'&amp;recorddo=insRecord&amp;formname='.$formname.'">';
		
		while($row_fields = $result_fields->fetch_assoc()) {
			if ($row_fields["required"] == "Yes") {
			$required = "required";
			} else {
				$required = "";
			}
			$fieldname = $row_fields["fieldname"];
			echo '<div class="form-group">
			    	<label for="'.$row_fields["fieldname"].'" class="col-sm-2 control-label">'.$row_fields["fieldalias"].'</label>';
			    	
			    	// tooltips
			    	//if ($row_fields["tooltip"] <> "") {
			    	//	echo ' <a href="#" data-toggle="tooltip" title="'.$row_fields["tooltip"].'" data-original-title="'.$row_fields["tooltip"].'">(i)</a>';
			    	//}
			    	echo '<div class="col-sm-10">';
			    	
			    	if ($row_fields["type"] == "Single Member List") {
			    		$setlist = "single";
			    		include $globals["ADMIN_DIR"].'memberlist.php';
			    	}

			    	if ($row_fields["type"] == "Multiple Member List"){
			    		$setlist = "multiple";
			    		include $globals["ADMIN_DIR"].'memberlist.php';
			    	}
			    
			    	if (substr($row_fields["type"],0,4) == "List"){
						
			    		$listname = $row_fields["fieldalias"];
						$listid = $row_fields["listid"];
						$_GET["fid"] = $row_fields["fid"];
			    		if ($row_fields["listid"] == 0) {
			    			echo 'Set up list';
			    		} else {
							$needarray = "No";
			    			include 'listoptions.php';
			    		}
			    	}
					
			    	 if ($row_fields["type"] == "Datetime") {
			    		echo '<div class="input-group">
								<span class="glyphicon glyphicon-calendar input-group-addon"></span><input id="'.$row_fields["fieldname"].'" name="'.$row_fields["fieldname"].'" type="text" placeholder="Date and Time"  class="form-control" '.$required.'></div>';
					}

					if ($row_fields["type"] == "Decimal") {
						echo '<div class="input-group">
							<input type="number" id="'.$row_fields["fieldname"].'" min="0" step="any" name="'.$row_fields["fieldname"].'" placeholder="'.$row_fields["fieldalias"].'"  class="form-control" '.$required.'>
							</div>';
					}

			    	if ($row_fields["type"] == "Text") {
			    		if ($row_fields["maxlength"] > 200) {
			    			echo '<textarea class="form-control" name="'.$row_fields["fieldname"].'" rows="3" maxlength="'.$row_fields["maxlength"].'" placeholder="'.$row_fields["fieldalias"].'" '.$required.'></textarea>';
			    		} else {
			    			echo '<input type="'.$row_fields["type"].'" maxlength="'.$row_fields["maxlength"].'" name="'.$row_fields["fieldname"].'" class="form-control" id="'.$row_fields["fieldname"].'" placeholder="'.$row_fields["fieldalias"].'" '.$required.'>';
			    		}
			    	}

			    	if ($row_fields["type"] == "Email" or $row_fields["type"] == "Password") {
 						
 			    		echo '<input type="'.$row_fields["type"].'" maxlength="'.$row_fields["maxlength"].'" name="'.$row_fields["fieldname"].'" class="form-control" id="'.$row_fields["fieldname"].'" placeholder="'.$row_fields["fieldalias"].'" '.$required.'>';
			    	}
			 
		  	echo '</div></div>';


		}
		 echo '<button type="submit" name="insRecord" class="btn btn-default">Save</button></form>';
    } else {
    	echo '<p><a href="admin.php?fielddo=adm&formid='.$formid.'&amp;formname='.$formname.'">Click here</a> to add fields to this form.</p>';
    }
}

// insert a new record
if (isset($_POST['insRecord']) and $recorddo == "insRecord") {
	$result_getfields = $conn->query($query_getfields = 'SELECT fieldname,formname,tablename, hs_fields.type from hs_fields, hs_forms where hs_fields.formid = hs_forms.formid and hs_forms.formid = '.$formid.' and showonform = "Yes" order by fieldorder');
	
	if ($result_getfields->num_rows > 0) {
		$fieldlist="";
		$i = 0;
		while ($row_getfields = $result_getfields->fetch_assoc()) {
			//echo "Field: ".$row_getfields["fieldname"]." Field type: ".$row_getfields["type"]." Field value: ".$_POST[$row_getfields["fieldname"]]."<br>";
			if ($i == 0) {
				$fieldlist = $row_getfields["fieldname"];
				// remove quotes and insert NULL if it's a Decimal
				if ($row_getfields["type"] == "Decimal" and $_POST[$row_getfields["fieldname"]] == "") {
					$valuelist = 'NULL';
				// convert multiple member list from array to string 
				} elseif ($row_getfields["type"] == "Multiple Member List") {
					$multiplevalues = implode(', ', $_POST[$row_getfields["fieldname"]]);
					$valuelist = '"'.$multiplevalues.'"';
				} else {
					$valuelist = '"'.$_POST[$row_getfields["fieldname"]].'"';
				}
			} else {
				$fieldlist = $fieldlist.','.$row_getfields["fieldname"];
				// remove quotes and insert NULL if it's a Decimal
				if ($row_getfields["type"] == "Decimal" and $_POST[$row_getfields["fieldname"]] == "") {
					$valuelist = $valuelist.',NULL';
				// convert multiple member list from array to string 
				} elseif ($row_getfields["type"] == "Multiple Member List") {
					
					$multiplevalues = implode(', ', $_POST[$row_getfields["fieldname"]]);
					$valuelist = $valuelist.',"'.$multiplevalues.'"';
					
				} else {
					$valuelist = $valuelist.',"'.$_POST[$row_getfields["fieldname"]].'"';
				}
			}			
			++$i;
			$tablename = $row_getfields["tablename"];
		}
	} 

	$query_ins = 'INSERT INTO '.$tablename.' ('.$fieldlist	.',regdate) VALUES ('.$valuelist.',now())';
	
	$sqlupdate = $conn->query($query_ins);
	if(!$sqlupdate) {
		die('Error:' . mysqli_error($conn));
	} else {
		echo '<h3>Member added successfully!</h3><p><a href="admin.php?formid='.$formid.'&amp;recorddo=insRecord&formname='.$formname.'">Add another record</a></p>';
	}
}
// delete selected record
if ($recorddo == "delRecord") {
	$recordid = $_GET['id'];

	// get the tablename
	$result_getTable = $conn->query($query_getTable = 'SELECT tablename FROM hs_forms where hs_forms.formid ='.$formid);
	if ($result_getTable->num_rows > 0) {
		while($row_getTable = $result_getTable->fetch_assoc()) {
			$tablename = $row_getTable["tablename"];
		}
	}

	// delete record from table
	$query_del = 'DELETE from '.$tablename.' WHERE id = '.$recordid;
	$sqlupdate = $conn->query($query_del);
	if(!$sqlupdate) {
		die('Error:' . mysqli_error($conn));
	} else {
		echo '<h3>Record deleted successfully!</h3><p><a href="admin.php?formid='.$formid.'&amp;recorddo=listrecords&amp;formname='.$formname.'">Back to Report</a></p>';
	}
}

// show modify record form
if ($recorddo == "updRecord") { 
	echo "<h3>Update Record</h3>";
	echo "Let's update this record!";

}

// apply selected record modifications
if (isset($_POST['updRecord']) and $formdo == "updRecord") { 
	echo "<h3>Record Updated (not really!)</h3>";
}   
?>