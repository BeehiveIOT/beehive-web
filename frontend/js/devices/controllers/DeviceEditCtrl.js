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
        $scope.model.serial_number = res.data.serial_number;
        $scope.model.device_secret = res.data.device_secret;
        $scope.model.pub_key = res.data.pub_key;
        $scope.model.sub_key = res.data.sub_key;
        $scope.model.template_id = res.data.template_id;
        $scope.model.commands = res.data.commands;
      }, function(err) {});
    };
    load($routeParams.deviceId);
  }
]);
