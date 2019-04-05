<?php
//var_dump ($fieldname);
//die();
    echo '<select class="form-control" name="'.$fieldname.'" required">';

if (isset($fieldvalue)) {
    echo '<option value="'.$fieldvalue.'">'.$fieldvalue.'</option>';
    echo '<option value="">--SELECT ONE--</option>';
}
echo '<option value="Member">Member</option>
<option value="Officer">Officer</option>
</select>';
?>