<?php get_header(); ?>
					<?php if (have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>
					<div class="box">
						<div class="title"><?php the_title(); ?></div>
						<div class="meta"><?php luna_posted_on(); ?></div>
						<?php the_content() ?>
					</div>
					<?php endwhile; ?>
					<?php comments_template( '', true ); ?>
					<?php endif; ?>
<?php get_footer(); ?>
