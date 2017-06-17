
var topTenListsAngularApp = angular.module('topTenListsAngularApp', []);

topTenListsAngularApp.controller('main', function($scope, $window, $log) {
	$scope.listItems = $window.topTenListsGlobal.items;

	$scope.newListItem = function() {
		var model = {'title' : '', 'image_url' : '', 'image_id' : ''};
		var length = $scope.listItems.push(model);
	};

	$scope.addImage = function(index) {
		// Create a new media frame
		frame = $window.wp.media({
			title: 'Select or Upload an Image for List Item #' + (index + 1),
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
            	$scope.listItems[index].image_url = attachment.url;
            	$scope.listItems[index].image_id = attachment.id;
        	});
    	});

    	frame.open();
	};

	$scope.removeItem = function(index) {
		if (confirm('Are you sure you want to remove this item?')) {
			$scope.listItems.splice(index, 1);
		}
	};

	$scope.moveItemUp = function(index) {
		// Switch with item above
		$scope.listItems.splice(index - 1, 2, $scope.listItems[index], $scope.listItems[index - 1]);
	};

	$scope.moveItemDown = function(index) {
		// Switch with item below
		$scope.listItems.splice(index, 2, $scope.listItems[index + 1], $scope.listItems[index]);
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