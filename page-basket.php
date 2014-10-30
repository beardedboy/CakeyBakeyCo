<?php
/*
Template Name: Basket Page
*/

get_header(); ?>



<section class="main_content-basket">
	<h1 class="h1"><?php echo get_the_title(); ?></h1>
	<?php while(have_posts()):the_post()?>
		<?php the_content(); ?>
	<?php endwhile; ?>

</section><!-- #main-content -->

<?php get_footer(); ?>