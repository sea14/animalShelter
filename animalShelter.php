<?php

/**
* Plugin Name: Animal Shelter Pets
* Plugin URI: 
* Description: Intended for use by Animal Shelters - a custom-post type plugin that allows saving information about either cats or dogs specifically
* Version: 1.0
* Author: Sharon Austin
* Author URI: http://www.sharon-elizabeth.com/
* License: GPL 2.0
**/

//create the post type of animals

add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type('animal',
		array(
			'labels' => array(
				'name' => __( 'Animals' ),
				'singular_name' => __( 'Animal' ),
				'add_new' => __( 'Add New', 'animal' ),
				'add_new_item' => __( 'Add new animal' ),
				'edit_item' => __( 'Edit Animal Information' ),
				'view_item' => __( 'View animal '),
			),
		'public' => true,
		'has_archive' => true,
		)
	);
}


//create our meta boxes
function add_animal_metaboxes() {
	add_meta_box('wp_animal_name', 'Animal Name');
	add_meta_box('wp_animal_status', 'Animal Status');
	add_meta_box('wp_animal_info', 'Animal Information');
}
		//for the animal name

		//for the animal status, a drop-down

		//will be a wysiwig for more info about the animal