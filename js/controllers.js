var premadeButtons = angular.module("premadeButtons_add", []);

premadeButtons.controller("formController", ["$scope", "$http" , function($scope, $http) {
		// Initialize the default values
	$scope.selectedButton = "blueButton"
	$scope.buttonText = "Button";
	$scope.buttonLink = "#";
	$scope.buttonFontsize = Number("12");
}]);
