<?php
/* Template Name: Animals Template */

?>
	<div id="primary">
			<div id = "content" role="main">

				<!--run a new query to get the posts of type 'animals' -->
				<?php
						$mypost = array( 'post_type' => 'animals', );
						$loop = new WP_QUERY( $mypost );

				?>

				<!--now we check to see if we have a post-->
				<?php if ( have_posts() ){ ?>


					<article id="post-<?php the_ID();  ?> " <?php post_class(); ?>>

						
						<?php 

							$post_meta_data = get_post_custom($post->ID);

							//set up variables to label each part of the array we'll want later
							$animal_name = $post_meta_data['animal_name'][0];
							$description = $post_meta_data['animal_description'][0];

						?>

							<!--output those variables to the page-->
						<strong>Animal Name</strong>: <?php echo $animal_name; ?> </br>
						<strong>Animal Description</strong>: <?php echo $description; ?>

				<?php } ?>

			</div> <!--close content div-->
	</div> <!--close primary div-->

	<?php wp_reset_query(); ?>


