<h3 class="top-ten-lists-title">
	<?php echo esc_html(sprintf('%s. %s', $item['display_order'], $item['title'])); ?>
</h3>
<?php if ($item['image_id']): ?>
	<div class="top-ten-lists-image">
		<?php echo wp_get_attachment_image($item['image_id'], 'large'); ?>
		<?php if($image = get_post($item['image_id'])): ?>
			<?php if($image->post_excerpt): ?>
				<p><i><?php echo $image->post_excerpt; ?></i></p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
<?php endif ?>
<div class="top-ten-lists-content">
	<?php echo wpautop($item['content']); ?>
</div>
