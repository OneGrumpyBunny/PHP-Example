<?php
$globals["BASE_URL"] = "http://www.hydrantsoft.com/sites/dev/bvfco11/";

$globals["INCL_DIR"] = "includes/";
$globals["IMG_DIR"] = "media/";
$globals["PAGES_DIR"] = "pages/";
$globals["ADMIN_DIR"] = "hs_admin/";


$result_title = $conn->query($query_title = "SELECT hs_value as site_title FROM hs_globals WHERE hs_label = 'site_title'");
$result_subtitle = $conn->query($query_subtitle = "SELECT hs_value as site_subtitle FROM hs_globals WHERE hs_label = 'site_subtitle'");
$result_badge = $conn->query($query_badge = "SELECT hs_value as badge_img FROM hs_globals WHERE hs_label = 'badge_img'");

// assign global variables

if ($result_title->num_rows > 0) {
	while($row_title = $result_title->fetch_assoc()) {
		$globals["SITE_TITLE"] = $row_title['site_title'];
	}
}

if ($result_subtitle->num_rows > 0) {
	while($row_subtitle = $result_subtitle->fetch_assoc()) {
		$globals["SITE_SUBTITLE"] = $row_subtitle['site_subtitle'];
	}
}

if ($result_badge->num_rows > 0){
	while($row_badge = $result_badge ->fetch_assoc()) {
		$globals["BADGE_IMG"] = $row_badge['badge_img'];
	}
}

?>