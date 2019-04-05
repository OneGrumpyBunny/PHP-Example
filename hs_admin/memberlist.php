<!-- memberlist.php -->

		
<?php
$result_members = $conn->query($query_members = "SELECT countyid, firstname, lastname FROM hs_users ORDER BY lastname, firstname");
	if ($result_members->num_rows > 0) {
		echo '<select data-placeholder="Select a Member" ';
		if ($setlist == "multiple") { 
			echo 'class="multiple-select" multiple="multiple" ';
			echo ' id="'.$fieldname.'" name="'.$fieldname.'[]" required>';
		} else {
			echo ' id="'.$fieldname.'" name="'.$fieldname.'" required>
			<option value="">--SELECT ONE--</option>';
		}
			while($row_members = $result_members->fetch_assoc()) {
				echo '<option id="'.$row_members["countyid"].'" value="'.$row_members["countyid"].'">'.$row_members["firstname"].' '.$row_members["lastname"].'</option>';
			}
		echo '</select>';
	}
?>