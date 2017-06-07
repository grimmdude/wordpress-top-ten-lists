<h2 class="top-ten-lists-title">
	<?php echo esc_html(sprintf('#%s %s', $item['display_order'], $item['title'])); ?>
</h2>
<?php if ($attachment_url = wp_get_attachment_url($item['image_id'])): ?>
	<img class="top-ten-lists-image" src="<?php echo esc_url($attachment_url); ?>" />
<?php endif ?>
<div class="top-ten-lists-content">
	<?php echo wpautop($item['content']); ?>
</div>

