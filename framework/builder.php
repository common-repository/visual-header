<?php 
/*************************************************************************************************************************************************************************
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 												Builder
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
**************************************************************************************************************************************************************************/ 
if ( !function_exists ( "vh_builder" )){
add_action('wp_ajax_vh_builder', 'vh_builder');
add_action('wp_ajax_nopriv_vh_builder', 'vh_builder'); 
function vh_builder($post_id=false) {
 
	global $post,$customize,$pagenow,$smof_data;
 	
		 
	$post_new =  !empty($_POST['vh_builder_js']['vh_post_new'])?sanitize_text_field($_POST['vh_builder_js']['vh_post_new']):'';
	$vh_post_id =  !empty($_POST['vh_builder_js']['vh_post_id'])?sanitize_text_field($_POST['vh_builder_js']['vh_post_id']):'';
	
 
 	 if(!empty($post_id)){
		$builder_json = get_post_meta($post_id , 'vh_builder_json', true);
	 }elseif(!empty($_REQUEST['library'])){
 		$library=  vh_library_array();
		$builder_json = !empty($library[$_REQUEST['id']]['value'])?$library[$_REQUEST['id']]['value']:'';
  		 
 	 }elseif(!empty($_REQUEST['json'])){
 		$builder_json =  !empty($_REQUEST['option'])?wp_kses_post($_REQUEST['option']):'';
  	 }else{
		$builder_json = get_post_meta($post->ID, 'vh_builder_json', true);
 	 } 
	 	 
	$get_option=!empty($builder_json)?json_decode(stripslashes($builder_json),true):'';

  	$navbar_json =!empty($get_option['navbar'])?urldecode($get_option['navbar']):'';
   	$navbar= vh_json_array_row($navbar_json);
 
	 $slug = get_post_field('post_name', $post_id);
 	$vh_has_default =has_filter('vh_has_default')? apply_filters('vh_has_default',$slug):'';
  	$default=!empty($vh_has_default)?'vh_is_default':'';	
	
	
	echo '<div class="vh_builder vh_desktop_active"  >';
	
  		$name =!empty($get_option['name'])?$get_option['name']:'';
 
 		echo '<div class=" vh_builder_content  ">';
 		
 
  		echo '<div class=" vh_builder_heading ">'; 
		
			if(!empty($vh_post_id)){
					echo '<input name="post_name" type="hidden" id="post_name" value="'.sanitize_title($slug).'" />';
					echo '<a class="vh_btn vh_builder_save "  >'.esc_html__('Save All Changes','visual-header').'</a>';
					echo '<a class="vh_btn vh_builder_back " href="'.admin_url().'post.php?post='.esc_attr($vh_post_id).'&action=edit">'.esc_html__('Back To Editor','visual-header').'</a>';
		  	}
			
			
			if($post_new =='is_new' || $pagenow == 'post-new.php'){
 				echo '<a class="vh_btn vh_frontend vh_frontend_new" home-url="'.home_url( '/').'" href="'.admin_url( 'customize.php' ).'">'.__('Frontend Editor','visual-header').'</a>';
 			}elseif(empty($vh_post_id)){
  				 $url=admin_url( 'customize.php' ).'?url='.urlencode(home_url( '/').'?p='.$post->ID).'&vh_post_id='.$post->ID;
 				echo '<a class="vh_btn vh_frontend" href="'.$url.'">'.__('Frontend Editor','visual-header').'</a>';
				
			}
 			
			vh_global_options($get_option);
			if(has_filter('vh_library')) {
  				echo '<a class="vh_btn vh_library ">'.esc_html__('Library','visual-header').'</a>';
			}
  			echo '<a class="vh_btn vh_import_header ">'.esc_html__('Import','visual-header').'</a>';
 			echo '<a class="vh_btn vh_export_header ">'.esc_html__('Export','visual-header').'</a>';
   			echo '<a class="vh_btn vh_make_it_default '.esc_attr($default).'">'.esc_html__('Make it Default','visual-header').'</a>';
			echo '<a class="vh_btn vh_desktop_layout">'.esc_html__('Desktop','visual-header').'</a>';
			echo '<a class="vh_btn vh_mobile_layout ">'.esc_html__('Mobile','visual-header').'</a>';
   
 		 		echo '</div>';
				 
 
 
			echo '<ul class="vh_navbar_list">';
 			
				if(has_filter('vh_builder_navbar')){ 
 				foreach(apply_filters('vh_builder_navbar', $navbar) as $navbar_key => $navbar_value):
 				   vh_builder_navbar($get_option,$navbar_key,$navbar_value);
 				endforeach;
				}
				
              
   			echo '</ul>';
  
 	 
		
 		echo '</div>';
		
 		$builder_json_textarea = !empty( $builder_json ) ? $builder_json : '';
  		echo '<textarea  type="hidden"   name="vh_builder_json" id="vh_builder_json">'.wp_kses_post($builder_json_textarea).'</textarea>';
 
  	
   	if( !empty($_REQUEST['library'])|| !empty($_REQUEST['json'])){
	die('');
	}
}  
}
/*************************************************************************************************************************************************************************
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 														Global Options
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
**************************************************************************************************************************************************************************/ 
if ( !function_exists ( "vh_global_options" )){
function vh_global_options($get_option=false) { 
	if(!empty(vh_global_options_array())){ 
	foreach(vh_global_options_array() as $id => $value):
			echo '<a class="vh_btn vh_global_options" data-id="'.esc_attr($id).'" data-row="global">';
				echo '<img src="'.esc_url($value['img']).'"><span>'.esc_html($value['name']).'</span>';
 				$options = !empty($get_option[$id])? urldecode($get_option[$id]):'';
				echo '<vh_data_json class="vh_data_json" data-row="global" >'.wp_kses_post($options).'</vh_data_json>';
			echo '</a>';
 	endforeach;
	 }
}
}
/*************************************************************************************************************************************************************************
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 														Global Options Array
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
**************************************************************************************************************************************************************************/ 
if ( !function_exists ( "vh_global_options_array" )){
function vh_global_options_array() { 
 	global $vh_globl_options;
 	$global=array();
 	if(has_filter('vh_global_options')) {
		$vh_globl_options = apply_filters('vh_global_options', $global);
  	}
	return $vh_globl_options;
 }
}
/*************************************************************************************************************************************************************************
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 														vh options rray_row
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
**************************************************************************************************************************************************************************/ 
if ( !function_exists ( "vh_json_array_row" )){
function vh_json_array_row($row){
	$options = json_decode(stripslashes($row),true);
   	$array = array();
	
	if(!empty($options)){
	foreach($options as $key => $value) :
		if(!empty($value)){
		foreach($value as $key => $value) :
				$array[$key] = $value;
		  
		endforeach;
		}
	endforeach;
	}
	return $array;
 }
  }
