<?php

/**
* Plugin Name: Animal Shelter Pets
* Plugin URI: http://github.com/sea14/animalShelter/
* Description: Intended for use by Animal Shelters - a custom-post type plugin that allows saving information about either cats or dogs specifically
* Version: 1.0
* Author: Sharon Austin
* Author URI: http://www.sharon-elizabeth.com/
* License: GPL 2
* /

//create the post type of animals

add_action( 'init', 'create_post_type' );
function create_Animal() {
	register_post_type('animal',
		array(
			'labels' => array(
				'name' => __( 'Animals' ),
				'singular_name' => ( 'Animal' )
			),
		'public' => true,
		'has_archive' => true,
		)
	);
}
