<?php get_header(); ?>
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
								<li><?php the_title(); ?></li>
  							<?php endwhile; ?>
  							</ul>
					</div>
					<?php query_posts(''); ?>
					<?php if (have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>
					<div class="box">
						<div class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
						<div class="meta"><?php luna_posted_on(); ?></div>
						<?php the_excerpt() ?>
					</div>
					<?php endwhile; ?>
					<?php endif; ?>
<?php get_footer(); ?>
