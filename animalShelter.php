<?php

/**
	* Plugin Name: Animal Shelter Plugin
	* Plugin URI: None
	* Description: A plugin for adding specific animal information to an animal shelter website.
	* Version: 1.0
	* Author: Sharon Austin
	* Author URI: None
	* License: GPL 2.0
**/



//call the action for creating a post type and create a metabox

add_action( 'init' , 'createAnimal_post_type');
function createAnimal_post_type() {
	register_post_type( 'animals',
		array(
				'labels' => array(
				'name' => __( 'Animals' ),
				'description' => __( 'Animal Description' ),
				'singular_name' => __( 'Animal' ),
				'edit_item' => __( ' Edit Animal Information' ),
				'add_new_item' => __( 'Add a new animal' ),
				'edit_item' => __( 'Edit this animal' ),


		),
		'public' => true,
		'has_archive' => true,
		'show_in_menu' => true,
		'show_ui' => true,
		'add_submenu_page' => true,
		'show_in_nav_menus' => true,
		'title' => 'course',
		'supports' => array( 'title', 'thumbnail' ),
		)

	);

}


//adding the meta box below
function add_animal_box() {

	add_meta_box(
		'animal_custom_meta_box',
		'Add Animal Information',
		'show_animal_box',
		'animals',
		'normal',
		'high',
		"wysiwyg-editor");
		
	add_action('save_post', 'save_custom_meta_animals', 1, 2);
		
}
add_action('add_meta_boxes', 'add_animal_box');

//create an array for the fields
$prefix = 'custom_';
$custom_animal_fields = array(
		array(
			'label' => 'Animal Name',
			'desc' => 'Animal Name',
			'id' => $prefix.'text2',
			'type' => 'text'
			),
		array(
			'label' => 'Animal Description',
			'desc' => 'Animal Description',
			'id' => $prefix.'textarea',
			'type' => 'textarea'
			)
);


//callback below

function show_animal_box() {


	$content = '';
	global $custom_animal_fields, $post;
	//using nonce for verification
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

	//begin the field table and loop
	echo '<table class="form-table">';
	foreach ($custom_animal_fields as $field) {

		//get value of field if it is in this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		//begin a table row
		echo '<tr>

		<th><label for="'.$field['id'].'">'.$field['label'].'</label></th><td>';

		switch($field['type']) {
			
			//case checking below

				//for the text boxes
				case 'text':
					echo '<input type="text" name="'.$field['id'].'" id="' .$field['id'].'" value="'.$meta. '" size="30" />
						<br /><span class="description">'.$field['desc'].'</span>';
					break;

				//for a textarea
				case 'textarea':
					$post_id = get_the_ID();
					echo '<textarea name="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
						<br /><span class="description">'.$field['desc'].'</span>';
						break;


		} //end switch

		echo '</td></tr>';

	} //end foreach loop

	echo '</table>'; //close the table

}



//save the data below
function save_custom_meta_animals($post_id, $post) {
	global $custom_meta_fields;


	if ( isset($_POST['custom_meta_box_nonce']) && !wp_verify_nonce($_POST['custom_meta_box_nonce'], __FILE__) ) {
    return $post_id;
}

	//check autosave,
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;




	//check permissions
	if ('page' == $post->post_type) {
		if(!current_user_can('edit_page', $post_id))
			return $post_id;
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}

	if(defined('DOING_AUTOSAVE') && (DOING_AUTOSAVE)){
		//loop through fields and save the data
		foreach ($custom_meta_fields as $field) {

		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {

			update_post_meta($post_id, $field['id'], $new);

			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}

		} //end our foreach

	}
}
	add_action('save_post', 'save_custom_meta_animals', 1, 2);


if(!function_exists('wp_get_current_user')) {
    include(ABSPATH . "wp-includes/pluggable.php"); 
}
