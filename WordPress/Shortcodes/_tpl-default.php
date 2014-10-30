<?php if($loop->have_posts()): ?>
	<?php while($loop->have_posts()) : $loop->the_post(); ?>	
		<?php the_title(); ?>
	<?php endwhile; ?>
<?php else : ?>
<?php endif; ?>  