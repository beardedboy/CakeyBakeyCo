<?php
/*
Template Name: Order Online Page
*/

get_header(); ?>



<section class="main_content main_content-shop">
	<?php while(have_posts()):the_post()?>
		<?php the_content(); ?>
	<?php endwhile; ?>

</section><!-- #main-content -->

<?php get_footer(); ?>