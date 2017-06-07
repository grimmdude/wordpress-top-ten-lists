<style type="text/css">
	#wp-post-lists-plugin div.mce-tinymce {border: 1px solid rgba(0,0,0,0.2);}
</style>

<div data-ng-app="topTenListsAngularApp" data-ng-controller="main" class="ng-cloak">
	<div style="border:1px solid #ddd;margin-bottom:10px;" class="top-ten-list-item" data-ng-repeat="item in listItems" data-ng-controller="item" data-ng-init="init(item, $index)">
		<div style="background:#ddd;padding:5px;">#{{item.display_order}}</div>
		<div style="padding:5px;">
			<p><input type="text" style="width:100%;" placeholder="#{{item.display_order}} Title" name="top_ten_list[{{$index}}][title]" data-ng-model="item.title" /></p>
			<p data-ng-show="!item.image_url">
				<a class="button" style="padding-left:5px;" data-ng-click="addImage()">
					<span class="dashicons dashicons-format-image" style="vertical-align:text-top;margin:0 2px;"></span>
					<?php _e('Add Image'); ?>
				</a>
				<input type="hidden" name="top_ten_list[{{$index}}][image]" data-ng-model="item.image">
			</p>
			<p data-ng-show="item.image_url">
				<img data-ng-src="{{item.image_url}}" data-ng-click="addImage()" style="height:200px;max-width:100%;cursor:pointer;" />
			</p>
			<input type="hidden" name="top_ten_list[{{$index}}][image_url]" data-ng-value="item.image_url" />
			<input type="hidden" name="top_ten_list[{{$index}}][image_id]" data-ng-value="item.image_id" />
			<input type="hidden" name="top_ten_list[{{$index}}][display_order]" data-ng-value="$index + 1" />
			<ttl-textarea index="$index" item="item">{{item.content}}</ttl-textarea>
		</div>
	</div>
	<p><a class="button" data-ng-click="newListItem()"><?php _e('New List Item'); ?></a></p>
</div>

<script>
	var topTenListsGlobal = {};
	topTenListsGlobal.items = <?php echo json_encode($list_items); ?>;
</script>
