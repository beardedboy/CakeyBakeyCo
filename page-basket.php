<?php
/*
Template Name: Basket Page
*/

get_header(); ?>



<section class="main_content-basket">
	<?php while(have_posts()):the_post()?>
		<?php the_content(); ?>
	<?php endwhile; ?>

</section><!-- #main-content -->

<?php get_footer(); ?>