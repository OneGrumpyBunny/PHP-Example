<?php 

// list options of selected list

	$result_secfields = $conn->query($query_secfields = "SELECT selectone, optionvalue FROM hs_lists, hs_secfields WHERE hs_secfields.listid = hs_lists.listid and hs_secfields.listid= '".$listid."' and showinlist = 1 ORDER BY optionorder");
	//echo $query_secfields;
    $i = 1;
	if ($result_secfields->num_rows > 0) {
        if ($needarray == "Yes") {
            echo '<select class="form-control" id="thisone!" name="'.$fieldname.'[]">';
        } else {
        
		    echo '<select class="form-control" id="thisone!" name="'.$fieldname.'">';
        }
		
		while($row_secfields = $result_secfields->fetch_assoc()) {
            //echo "<option>Fieldvalue: ".$fieldvalue." row_secfields[selectone}: ".$row_secfields["selectone"]."</option>";
            if ($i == 1 and $row_secfields["selectone"] == "Yes") {
                if ($fieldvalue != "") {
                    echo '<option value="'.$fieldvalue.'">'.$fieldvalue.'</option>';
                } 
                echo '<option value="">-- Select One --</option>';
                
            }
            
			echo '<option value="'.$row_secfields["optionvalue"].'">'.$row_secfields["optionvalue"].'</option>';
            $i++;
		}
		echo '</select>';	
        
	}
?>