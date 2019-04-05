<?php

// which form are we doing?
if (isset($_GET["listid"])) {
	$listid = $_GET["listid"]; 
} else {
	$listid = "";
}

// which function are we doing?
if (isset($_GET["listdo"])){
	$listdo=$_GET["listdo"];
} else {
	$listdo = "";
}

// no parameters means list all available lists with options
if ($listdo == "build") {
		 echo '<h3>List Builder</h3><div class="table-responsive"><table class="table">
		 		<form name="newformfield" class="form-horizontal" method="post" action="admin.php?listdo=insList">';
		 
		 echo '<tr style="background-color: #eee;border: 2px solid #bbb;"><td colspan="3"><strong>Add New List</strong></td></tr><tr><td>&nbsp;</td><td>List Name</td><td>Start with "--SELECT ONE--"?</td></tr>';
		 
		 // new list form
		 echo '<tr>
		 	   <td>&nbsp;</td><td><input class="form-control" type="text" placeholder="List Name" name="listname" value="" required></td>
			   <td>
			  	<select class="form-control" name="selectone" required>
				<option value="Yes">Yes</option>
				<option value="No">No</option>
				</select>';

		 echo '</td></tr><tr><td colspan="3"><button type="submit" name="insList" class="btn btn-default">Save New List</button></form></td></tr>';

		 echo '<tr style="background-color: #eee;border: 2px solid #bbb;"><td colspan="3"><strong>Modify Lists Below</strong></td></tr>';
		 echo '<form name="updateList" method="Post" action="admin.php?listdo=updList">';
		 echo '<tr><td>Actions</td><td>List Name</td><td>Start with "--SELECT ONE--"?</td></tr>';
		 
		 // get the lists
		 $result_lists = $conn->query($query_lists = "SELECT listname, listid, selectone FROM `hs_lists` ORDER by listname");
		 	if ($result_lists->num_rows > 0) {
				while($row_lists = $result_lists->fetch_assoc()) {

					echo '<tr><td>';

					// action button - edit fields
					echo '<a title="Edit List Items" href="admin.php?listdo=adm&amp;listid='.$row_lists["listid"].'&amp;listname='.$row_lists["listname"].'"><span class="glyphicon glyphicon-th-list"></span></a> ';
					
					// action button - edit list details 
					//echo '<a title="Edit List Details" href="admin.php?listdo=updList&amp;listname='.$row_lists["listname"].'&amp;listid='.$row_lists["listid"].'"><span class="glyphicon glyphicon-pencil"></span></a> '; 
					
					// action button - delete list
					echo '<a title="Delete List" href="admin.php?listdo=delList&amp;listid='.$row_lists["listid"].'&amp;listname='.$row_lists["listname"].'"><span class="glyphicon glyphicon-remove"></span></a></td>
					<td><input type="hidden" name="listid[]" value="'.$row_lists["listid"].'">
						<input type="text" class="form-control" name="listname[]" value="'.$row_lists["listname"].'" required></td><td>
						<select class="form-control" name="selectone[]" required>';
						if ($row_lists["selectone"] <> "") {
							echo '<option value="'.$row_lists["selectone"].'">'.$row_lists["selectone"].'</option>';
						}
						echo '<option value="">--SELECT ONE--</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
						</select>';
				}						
			} 
			echo '<tr><td colspan="3"><button type="submit" name="updList" class="btn btn-default">Save Changes</button></td></tr></form></table></div>';
}

// insert a new list
if ($listdo == "insList") {
	
	// insert list details into lists table
	$query_ins = 'INSERT INTO hs_lists (listname) VALUES ("'.$_POST["listname"].'")';
	//echo $query_ins."<br>";
	
	$sqlupdate = $conn->query($query_ins);
	
	if(!$sqlupdate) {
		die('Error:' . mysqli_error($conn));
	} else {
		$newlistid = $conn->insert_id;
		echo '<h3>List added successfully!</h3><p><a href="admin.php?listdo=adm&listid='.$newlistid.'&listname='.$_POST["listname"].'">Add options to this list.</a></p>';
	}
}

// update list details

if ($listdo == "updList") {

	$listname = $_POST['listname'];
	$listid = $_POST['listid'];
	$selectone = $_POST['selectone'];
	
	// update field details
	foreach( $listid as $key => $n ) {
		
		// update fields table
		$query = 'UPDATE hs_lists SET listname = "'.$listname[$key].'", selectone = "'.$selectone[$key].'" WHERE listid = '.$n; 
		//echo $query."<br>";
		$sqlupdate = $conn->query($query);
		if(!$sqlupdate) {
			die('Error:' . mysqli_error($conn)); 
		}
	}
	echo '<h3>Lists updated successfully!</h3><p><a href="admin.php?listdo=build">Back to List Builder</a></p>';
}

if ($listdo == "delList") {
	// delete list 
	$query_del = 'DELETE FROM hs_lists WHERE listid = '.$_GET["listid"];
	$query_delsecs = 'DELETE FROM hs_secfields WHERE listid = '.$_GET["listid"];
	//echo $query_del."<br>";
	
	$sqlupdate = $conn->query($query_del);
	$sqlupdate2 = $conn->query($query_delsecs);
	if(!$sqlupdate or !$sqlupdate2) {
		die('Error:' . mysqli_error($conn));
	} else {
		echo '<h3>List deleted successfully!</h3><p><a href="admin.php?listdo=build">Back to List Builder</a></p>';
	}
}

// display form to modify list items
if ($listdo == "adm") {
	// show form to add a new option

	echo '<h3>List Builder - '.$_GET["listname"].'</h3><div class="table-responsive">
			<table class="table"><form name="newlistfield" class="form-horizontal" method="post" action="admin.php?listdo=InsListItem&amp;listid='.$listid.'&amp;listname='.$_GET["listname"].'">
			<tr style="background-color: #eee;border: 2px solid #bbb;"><td colspan="3"><strong>Add a New List Item</strong></td></tr>';		

	echo '<tr><td>&nbsp;</td><td>List Item</td><td>Order in List</td></tr>
		  <tr><td>&nbsp;</td><td><input type="text" class="form-control" placeholder="List Item" name="optionvalue" required></td><td><input class="form-control" type="text" name="optionorder" value="" required></td></tr>
		  <tr><td colspan="3"><button type="submit" class="btn btn-default" name="UpdList">Save New List Item</button></td></tr></form>';
	echo '<tr style="background-color: #eee;border: 2px solid #bbb;"><td colspan="3"><strong>Modify List Items Below</strong></td></tr>';

		 echo '<tr><td>Actions</td><td>List Item</td><td>Order in List</td></tr>';	  
	echo '<form name="updlistfield" class="form-horizontal" method="post" action="admin.php?listdo=UpdListItem&amp;listid='.$listid.'&amp;listname='.$_GET["listname"].'">';

	// display current options with modify
	$result_secfields = $conn->query($query_secfields = "SELECT optionvalue,optionorder,id FROM hs_secfields WHERE hs_secfields.listid= '".$listid."' and showinlist = 1 ORDER BY optionorder");
	if ($result_secfields->num_rows > 0) {
		while($row_secfields = $result_secfields->fetch_assoc()) {
			echo '<tr><td style="text-align:center;"><a title="Delete this Field" href="admin.php?listid='.$listid.'&amp;fid='.$row_secfields["id"].'&amp;listdo=DelListItem&amp;listname='.$_GET["listname"].'"><span class="glyphicon glyphicon-remove"></span></a></td>
				  <td><input type="hidden" name="id[]" value="'.$row_secfields["id"].'">
				  <input type="text" class="form-control" placeholder="List Item" name="optionvalue[]" value="'.$row_secfields["optionvalue"].'">
				  <td><input type="text" class="form-control" placeholder="Order in List" name="optionorder[]" value="'.$row_secfields["optionorder"].'"></td></tr>';
		}
	}
	echo '<tr><td colspan="3"><button type="submit" class="btn btn-default" name="UpdListItem">Save Changes</button></td></tr></table></form></div>';
}



// insert list item
if ($listdo == "InsListItem") {
// insert list specs into specs table
	$query_ins = 'INSERT INTO hs_secfields (optionvalue,optionorder,listid,showinlist) VALUES("'.$_POST["optionvalue"].'",'.$_POST["optionorder"].','.$listid.',1)';
	//echo $query_ins;
	$sqlupdate = $conn->query($query_ins);
	if(!$sqlupdate) {
		die('Error:' . mysqli_error($conn));
	} else {
		echo '<h3>New list item added successfully!</h3><p><a href="admin.php?listdo=adm&amp;listid='.$listid.'&amp;listname='.$_GET["listname"].'">Back to Modify List</a></p>';
	}
}


//Update list items
if ($listdo == "UpdListItem"){

	$optionvalue = $_POST['optionvalue'];
	$optionorder = $_POST['optionorder'];
	$id = $_POST['id'];
	
	// update field details
	foreach( $id as $key => $n ) {
		
		// update fields table
		$query = 'UPDATE hs_secfields SET optionvalue = "'.$optionvalue[$key].'", optionorder = '.$optionorder[$key].',listid = '.$listid.' WHERE id = '.$n; 
		//echo $query."<br>";
		$sqlupdate = $conn->query($query);
		if(!$sqlupdate) {
			die('Error:' . mysqli_error($conn)); 
		}
	}	
	echo '<h3>List item updated successfully!</h3><p><a href="admin.php?listdo=adm&amp;listid='.$listid.'&amp;listname='.$_GET["listname"].'">Back to Modify List</a></p>';
}

// delete a list item
if ($listdo == "DelListItem") {

	$query_del = 'DELETE FROM hs_secfields WHERE id = '.$_GET["fid"];
	//echo $query_del;
	$sqlupdate = $conn->query($query_del);
	if(!$sqlupdate) {
		die('Error:' . mysqli_error($conn));
	} else {
		echo '<h3>List item deleted successfully!</h3><p><a href="admin.php?listdo=adm&amp;listid='.$listid.'&amp;listname='.$_GET["listname"].'">Back to Modify List</a></p>';
	}
}
?>