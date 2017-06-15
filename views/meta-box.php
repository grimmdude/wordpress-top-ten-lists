<style type="text/css">
	#wp-post-lists-plugin div.mce-tinymce {border: 1px solid rgba(0,0,0,0.2);}
</style>

<div data-ng-app="topTenListsAngularApp" data-ng-controller="main" class="ng-cloak">
	<div style="border:1px dashed #ddd;margin-bottom:10px;padding:10px;overflow:hidden;" class="top-ten-list-item" data-ng-repeat="item in listItems" data-ng-controller="item" data-ng-init="init(listItems, $index)">
		<div style="clear:both;margin-bottom:10px;overflow:hidden;">
			<div data-ng-bind="item.display_order + '.'" style="float:left;margin-right:10px;font-size:1.8em;line-height:1.4em;"></div>
			<div style="float:left;width:87%;">
				<input type="text" placeholder="Title" name="top_ten_list[{{$index}}][title]" data-ng-model="item.title" style="width:100%;font-size:1.3em;height:2em;" />
			</div>
		</div>
		<p data-ng-show="!item.image_url">
			<a class="button" style="padding-left:5px;" data-ng-click="addImage()">
				<span class="dashicons dashicons-format-image" style="margin:3px 2px;"></span>
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
		<div style="clear:both;margin-top:10px;">
			<div style="float:left;">
				<a href="javascript:;" style="text-decoration:none;" title="Move item up a number." data-ng-show="item.display_order > 1" data-ng-click="moveItemUp()"><span class="dashicons dashicons-arrow-up-alt"></span></a>
				<a href="javascript:;" style="text-decoration:none;" title="Move item down a number." data-ng-show="item.display_order < listItems.length" data-ng-click="moveItemDown()"><span class="dashicons dashicons-arrow-down-alt"></span></a>
			</div>
			<div style="float:right;text-align:right;">
				<a href="javascript:;" style="color:#a00;" data-ng-click="removeItem()">Remove Item</a>
			</div>
		</div>
	</div>
	<p><a class="button" data-ng-click="newListItem()"><?php _e('New List Item'); ?></a></p>
</div>

<script>
	var topTenListsGlobal = {};
	topTenListsGlobal.items = <?php echo json_encode($list_items); ?>;
</script>
