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
		'title' => 'Animal',
		'supports' => array( 'Animal', 'thumbnail' ),
		)

	);

}


//adding the meta box below
function add_animal_box() {

	add_meta_box(
		'custom_animal_meta_box',
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
$prefix = 'animal_';		
	$animalBox = array(
		'id' => 'animal-meta-box',
		'title' =>'animal information',
		'page' => 'animal',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			
				array('label' => 'Animal Name',
					'desc' => 'Animal Name',
					'id' => $prefix.'name',
					'type' => 'text'
				),

				array(
					'label' => 'Animal Description',
					'desc' => 'Animal Description',
					'id' => $prefix.'description',
					'type' => 'textarea'
				),
				
		)
);



//callback below

function show_animal_box() {


	$content = '';
	global $animalBox;
	global $post;
	//using nonce for verification
	echo '<input type="hidden" name="custom_animal_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

	//wp editor info
	$editor_id = 'animal_description';

	//begin the field table and loop
	echo '<table class="form-table">';
	foreach ($animalBox['fields'] as $field) {

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
					$content = $meta;
					wp_editor( $content, $editor_id );
						break;

		} //end switch

		echo '</td></tr>';

	} //end foreach loop

	echo '</table>'; //close the table

}



//save the data below
function save_animals_details($post_id) {
	
	    if( isset($_POST["animal_description"]) ) { update_post_meta($post_id, "animal_description", $_POST["animal_description"]); }        
        if( isset($_POST["animal_name"]) ) { update_post_meta($post_id, "animal_name", $_POST["animal_name"]); }
        
}

add_action('save_post', 'save_animals_details',1,2);



