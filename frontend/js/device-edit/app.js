angular.module('beehive', [
  'ngRoute',
  'controllers',
  'directives',
  'services'
])
.config(['$routeProvider', function($routeProvider) {
  $routeProvider
  .when('/',{
    templateUrl:'/partials/device/edit.html',
    controller: 'EditDeviceController'
  })
  .otherwise({
    redirectTo: '/'
  });
}]);
