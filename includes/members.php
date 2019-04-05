<!-- line officers -->

<?php
$result_lineofficers = $conn->query($query_lineofficers = "SELECT displayname, photo, membersince, lifemember, operationalrank FROM hs_users WHERE ".$row_featured["page_param"]);

	if ($result_lineofficers->num_rows > 0) {
    	while($row_lineofficers = $result_lineofficers->fetch_assoc()) {
      	if ($row_lineofficers["lifemember"] == 'Yes') {
      		$lifemember = '<p style="text-align: center;">Life Member</p>';
		} else {
			$lifemember ='<p style="text-align: center;">&nbsp;</p>';
		}
      		echo '<div class="col-lg-4 center cards">
				<img src="'.$globals["IMG_DIR"].'members/'.$row_lineofficers["photo"].'">
				<h3>'.$row_lineofficers["displayname"].'</h3>
				<p style="text-align: center;"><em>'.$row_lineofficers["operationalrank"].'</em></p>
				'.$lifemember.'<p style="text-align: center;">'.$row_lineofficers["membersince"].'</p></div>';
      	}
  	} 
  	//echo "You are here!";
?>