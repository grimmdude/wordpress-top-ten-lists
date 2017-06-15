
var topTenListsAngularApp = angular.module('topTenListsAngularApp', []);

topTenListsAngularApp.controller('main', function($scope, $window, $log) {
	$scope.listItems = $window.topTenListsGlobal.items;

	$scope.newListItem = function() {
		var displayOrder = $scope.listItems.length + 1;
		var model = {'display_order' : displayOrder, 'title' : '', 'image_url' : '', 'image_id' : ''};
		var length = $scope.listItems.push(model);
	};
});

topTenListsAngularApp.controller('item', function($scope, $window, $log) {
	$scope.items;
	$scope.index;
	$scope.item;

	$scope.init = function(items, index) {
		$scope.items = items;
		$scope.index = index;
		$scope.item = $scope.items[$scope.index];
	};

	$scope.addImage = function() {
		// Create a new media frame
		frame = $window.wp.media({
			title: 'Select or Upload an Image for List Item #' + $scope.item.display_order,
			button: {
				text: 'Use this image'
			},
			//frame: 'post',
			multiple: false  // Set to true to allow multiple files to be selected
	    });

		// When an image is selected in the media frame...
    	frame.on('select', function() {
      
			// Get media attachment details from the frame state
			var attachment = frame.state().get('selection').first().toJSON();

			$scope.$apply(function() {
            	$scope.item.image_url = attachment.url;
            	$scope.item.image_id = attachment.id;
        	});
    	});

    	frame.open();
	};

	$scope.removeItem = function() {
		if (confirm('Are you sure you want to remove this item?')) {
			$scope.items.splice($scope.index, 1);
		}
	};

	$scope.moveItemUp = function() {
		// Switch display order with item above
		$scope.items[$scope.index - 1].display_order++;
		$scope.items[$scope.index].display_order--;
	};

	$scope.moveItemDown = function() {
		// Switch display order with item below
		$scope.items[$scope.index + 1].display_order--;
		$scope.items[$scope.index].display_order++;
		$scope.items = $scope.items.sort(function(a, b) {return a - b;});
		$log.info($scope.items);
	};
});

topTenListsAngularApp.directive('ttlTextarea', ['$window', function($window) {
	return {
		restrict: 'E',
		scope: {
			itemIndex: '=index',
			item: '='
		},
		template: '<textarea data-ng-bind="item.content"></textarea>',
		link: function(scope, element) {
			var textarea = element.find('textarea');
			var id = 'top_ten_list_editor_' + scope.itemIndex;
			textarea.attr('id', id).attr('name', 'top_ten_list[' + scope.itemIndex + '][content]');
			$window.tinyMCE.execCommand('mceAddEditor', false, id); 
		}
	}
}]);