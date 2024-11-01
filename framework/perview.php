<?php

/*************************************************************************************************************************************************************************
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 														Builder Perview Reload
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
**************************************************************************************************************************************************************************/ 
if ( !function_exists ( "vh_header_perview" )){
add_action('wp_ajax_vh_header_perview', 'vh_header_perview');
add_action('wp_ajax_nopriv_vh_header_perview', 'vh_header_perview'); 
function vh_header_perview(){
 			
	$visualheader=!empty($_POST['header_perview'])?wp_kses_post($_POST['header_perview']):'';
 	$header= json_decode(stripslashes($visualheader),true);
	
	if(has_filter('vh_header_perview')) {
		 apply_filters('vh_header_perview', $header);
	}
	if(has_filter('vh_header_perview_css')) {
		 apply_filters('vh_header_perview_css', $header);
	}
  		
 
	if(!empty($_POST['header_perview'])){
		die('');
	}
	
}
}
 
 ?>
