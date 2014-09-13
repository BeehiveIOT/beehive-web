angular.module('beehive', [
  'ngRoute'
])
.config(['$routeProvider', function($routeProvider) {
  $routeProvider
  .when("/", {
    templateUrl: "/partials/devices/list.html",
    controller: "DeviceListCtrl"
  })
  .when("/:deviceId/edit", {
    templateUrl: "/partials/devices/edit.html",
    controller: "DeviceEditCtrl"
  })
  .when("/create", {
    templateUrl: "/partials/devices/create.html",
    controller: "DeviceCreateCtrl"
  })
  .otherwise({
    redirectTo: "/"
  })
  ;
}]);
