<?php
/*************************************************************************************************************************************************************************
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 												Builder Customize  
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
**************************************************************************************************************************************************************************/ 
if ( !function_exists ( "vh_builder_customize" )){
add_action('wp_ajax_vh_builder_customize', 'vh_builder_customize');
add_action('wp_ajax_nopriv_vh_builder_customize', 'vh_builder_customize'); 
 function vh_builder_customize() {
	global $customize;
	
	$vh_post_id=!empty($_POST['vh_builder_js']['vh_post_id'])?sanitize_key($_POST['vh_builder_js']['vh_post_id']):'';
 	echo '<div id="vh_metabox" class="vh_customize">';
	echo '<div class="vh_panel">';
  		vh_builder($vh_post_id);
	echo '</div>';
	echo '</div>';
	die('');
	
} 
} 
/*************************************************************************************************************************************************************************
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 												Background Perview   
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
**************************************************************************************************************************************************************************/ 
if ( !function_exists ( "vh_background_perview" )){
add_action('wp_ajax_vh_background_perview', 'vh_background_perview');
add_action('wp_ajax_nopriv_vh_background_perview', 'vh_background_perview'); 
 function vh_background_perview() {
	 
	echo '<div class="vh_background_perview_warp">';
	echo '<div class="vh_background_perview">';
	
		echo __('Background Perview: ','visual-header');
		echo '<a class="vh_background_default vh_background_active" data-bg="default">'.esc_html__('Defualt','visual-header').'</a>';
		echo '<a class="vh_background_light" data-bg="light">'.esc_html__('Light','visual-header').'</a>';
		echo '<a class="vh_background_dark" data-bg="dark">'.esc_html__('Dark','visual-header').'</a>';
 		 
	echo '</div>';
	echo '</div>';
	die('');

}
}
/*************************************************************************************************************************************************************************
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 															Create Customiz
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
**************************************************************************************************************************************************************************/ 
if ( !function_exists ( "vh_create_post" )){
add_action('wp_ajax_vh_create_post', 'vh_create_post');
add_action('wp_ajax_nopriv_vh_create_post', 'vh_create_post');
function vh_create_post() {
	
	$visualheader=!empty($_POST['vh_builder_json'])?wp_kses_post($_POST['vh_builder_json']):'';
 	$my_post = array(
		'post_title'    => __('New Header','visual-header'),
		'post_status' => 'publish',
		'post_author'   => get_current_user_id(),
		'post_type'  => 'visualheader',
		'meta_input'    => array(
			'vh_builder_json' =>$visualheader,
		)
 	);

	$post_create =  wp_insert_post( $my_post ); 
     if($post_create){
		 echo $post_create;
	 }
   
    wp_die();
}
}
/*************************************************************************************************************************************************************************
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 															Builder Save
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
**************************************************************************************************************************************************************************/ 
if ( !function_exists ( "vh_builder_save" )){
add_action('wp_ajax_vh_builder_save', 'vh_builder_save');
add_action('wp_ajax_nopriv_vh_builder_save', 'vh_builder_save');
function vh_builder_save() {
	
 	if(!empty($_POST['vh_builder_json'])) {
		$vh_builder = wp_kses_post($_POST['vh_builder_json']);
	 	$vh_post_id=!empty($_POST['vh_builder_js']['vh_post_id'])?sanitize_key($_POST['vh_builder_js']['vh_post_id']):'';
        update_post_meta($vh_post_id, 'vh_builder_json', $vh_builder);
    }

}
}
/*************************************************************************************************************************************************************************
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 															Customize Post Link
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
**************************************************************************************************************************************************************************/ 
if ( !function_exists ( "vh_customize_post_link" )){
add_filter( 'post_row_actions', 'vh_customize_post_link', 10, 2 );
function vh_customize_post_link( $actions, $post ) {
	 
	if($post->post_type =='visualheader'){
		if ( current_user_can('edit_post', $post->ID )  ) {
			$url=admin_url( 'customize.php' ).'?url='.urlencode(home_url( '/').'?p='.$post->ID).'&vh_post_id='.$post->ID;
   			$actions['vh_customize'] = '<a  href="'.$url.'"  >'.__('Frontend Editor','visual-header').'</a>' ;
  		}
	}
	
	return $actions;	 
}
}	
/*************************************************************************************************************************************************************************
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 															  Customize Register
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
**************************************************************************************************************************************************************************/ 
if ( !function_exists ( "vh_customize_register" )){
add_action( 'customize_register', 'vh_customize_register' );
function vh_customize_register( $wp_customize ) {
    $wp_customize->add_setting( 'vh_builder_json', array(
			'type' => 'option',
			'default' => '',
			'transport' => 'postMessage',
     	) 
	 );
    $wp_customize->add_control( 'vh_builder_json', array(
			 'section' => 'static_front_page',
			'type'    => 'textarea',
		)
	);
}
}