<h2><?php echo esc_html(sprintf('#%s %s', $item['display_order'], $item['title'])); ?></h2>
<?php if ($attachment_url = wp_get_attachment_url($item['image_id'])): ?>
	<img src="<?php echo esc_url($attachment_url); ?>" />
<?php endif ?>
<?php echo esc_html($item['content']); ?>

