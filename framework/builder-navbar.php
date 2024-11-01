<?php
/*************************************************************************************************************************************************************************
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 																	Navbar Builder  
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
**************************************************************************************************************************************************************************/ 
if ( !function_exists ( "vh_builder_navbar" )){
function vh_builder_navbar($get_option=false,$navbar_key=false,$navbar_value=false){
   
   
   				if(has_filter('vh_builder_column')){ 
				
				}
 

  	$navbar_option =!empty($navbar_value['option'])?urldecode($navbar_value['option']):'';
 	$navbar_name =!empty($navbar_value['name'])?$navbar_value['name']:'';
 
   
	//Section
	echo '<li class="vh_navbar_item" data-key="'.esc_attr($navbar_key).'" data-id="navbar"  data-row="navbar" >';
	echo '<vh_data_json class="vh_data_json"  data-row="navbar">'.wp_kses_post($navbar_option).'</vh_data_json>';
    	
		
		
		
		$data_navbar_name = is_rtl()?  __('Options','visual-header').' '.$navbar_name :  $navbar_name .' '.__('Options','visual-header');

		echo '<div class="vh_navbar_title" data-name="'.esc_attr($data_navbar_name).'">';
        	echo '<a class="vh_navbar_options" ></a>';
 		echo '</div>';
		
		echo '<div class="vh_navbar_content">';
 			echo '<ul class="vh_column_list ">';
			   
   				if(has_filter('vh_builder_column')): 
				foreach(apply_filters('vh_builder_column',array()) as $column_key => $column_value) :
				
					if($column_value['child'] == $navbar_key){
						vh_builder_column($get_option,$column_key,$column_value);
				}
		
				endforeach;
				endif;
				   
			echo '</ul>';
  		echo '</div>';
        
	echo '</li>';
	
}} 
 