<?php 
get_header();
$user = wp_get_current_user();
if ($user->ID != 0) {
	$last_visit = new DateTime($_SESSION['last_visit']);
} else {
	unset($last_visit);
}
?>
<div class="box">
	<div class="title">Les derniers articles</div>
	<ul class="news news-left">
	<?php query_posts('posts_per_page=5&paged=1'); ?>
	<?php while (have_posts()) : the_post(); ?>
		 <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	<?php endwhile; ?>
	</ul>

	<ul class="news news-right">
	<?php query_posts('posts_per_page=5&paged=2'); ?>
	<?php while (have_posts()) : the_post(); ?>
		<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	<?php endwhile; ?>
	</ul>
</div>

<?php query_posts(''); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<?php $post_date = new DateTime(get_the_date('Y-m-d H:i:s'))?>
<div class="box">
	<div class="title<?php echo ($post_date > $last_visit) ? ' unread' : ''; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
	<div class="meta"><?php luna_posted_on(); ?></div>
	<?php the_excerpt() ?>
</div>
<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
