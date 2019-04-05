<!-- yes/no list -->
<?php 
if ($needarray == "Yes") {
	echo '<select class="form-control" id="thisone!" name="'.$fieldname.'[]">';
} else {
	echo '<select class="form-control" id="thisone!" name="'.$fieldname.'">';
}
if ($fieldvalue != "") {
	echo '<option value="'.$fieldvalue.'">'.$fieldvalue.'</option>';
} 
echo '<option value="Yes">Yes</option>
		<option value="No">No</option>';

?>