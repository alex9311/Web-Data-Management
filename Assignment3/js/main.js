var app = angular.module('myApp', []);

app.controller('MyController', function($scope) {
	xdmp.httpGet("http://feeds.bbci.co.uk/news/world/rss.xml?edition=uk");
	
	$scope.person = {
		name: results
	};
});
