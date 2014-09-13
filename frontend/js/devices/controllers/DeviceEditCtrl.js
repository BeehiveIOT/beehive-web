angular.module('beehive')
.controller('DeviceEditCtrl', [
  '$scope',
  '$routeParams',
  'Device',
  function($scope, $routeParams, Device) {
    // $scope.modelo = {};

    var load = function(deviceId) {
      Device.get(deviceId).then(function(res){
        $scope.model = {};
        $scope.model.id = res.data.id;
        $scope.model.name = res.data.name;
        $scope.model.description = res.data.description;
        $scope.model.is_public = res.data.is_public;
        $scope.model.product_id = res.data.product_id;
        $scope.model.device_secret = res.data.device_secret;
        $scope.model.template = res.data.template;
      }, function(err) {});
    };
    load($routeParams.deviceId);
  }
]);
