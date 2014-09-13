angular.module("beehive").controller("DeviceListCtrl", [
  "$scope",
  "$rootScope",
  "Device",
  function($scope, $rootScope, Device) {
    $scope.devices = [];
    $scope.search = "";
    Device.getAll().then(function(res){
      $scope.devices = res.data;
    }, function(err) {
      alert('error');
    });
  }
]);
