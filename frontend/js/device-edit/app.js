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
  .when('/commands', {
    templateUrl:'/partials/device/commands.html',
    controller: 'CommandsController'
  })
  .when('/commands/:commandId', {
    templateUrl: '/partials/device/command.html',
    controller: 'CommandDetailController'
  })
  .when('/commands/create', {
    templateUrl: '/partials/device/command.html',
    controller: 'CommandDetailController'
  })
  .otherwise({
    redirectTo: '/'
  });
}]);
