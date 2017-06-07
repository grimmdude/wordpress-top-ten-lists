
var topTenListsAngularApp = angular.module('topTenListsAngularApp', []);

topTenListsAngularApp.controller('main', function($scope, $window, $log) {
	$scope.test = 'hi';
	$scope.listItems = $window.topTenListsGlobal.items;

	$scope.newListItem = function() {
		var displayOrder = $scope.listItems.length + 1;
		var model = {'display_order' : displayOrder, 'title' : '', 'image_url' : '', 'image_id' : ''};
		var length = $scope.listItems.push(model);
	};
});

topTenListsAngularApp.controller('item', function($scope, $window, $log) {
	$scope.item;

	$scope.init = function(item, index) {
		$scope.item = item;
	};

	$scope.addImage = function() {
		// Create a new media frame
		frame = $window.wp.media({
			title: 'Select or Upload an Image for List Item #' + $scope.item.display_order,
			button: {
				text: 'Use this image'
			},
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