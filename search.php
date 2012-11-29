<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
<?php get_header(); ?>
<?php if (have_posts()) : ?>
<div class="box">
	<div class="title">Résultat de la recherche pour : <?php echo get_search_query(); ?></div>
</div>
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="box">
			<div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
			<div class="meta"><?php luna_posted_on(); ?></div>
			<?php the_excerpt() ?>
		</div>
	<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
