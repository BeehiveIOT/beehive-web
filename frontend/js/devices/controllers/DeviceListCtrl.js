angular.module("beehive").controller("DeviceListCtrl", [
  "$scope",
  "$rootScope",
  "Device",
  "Template",
  function($scope, $rootScope, Device, Template) {
    function getByTemplate(templateId) {
      Device.getByTemplate(templateId).then(function(res){
        $scope.devices = res.data;
      }, function(err) {
        alert('error');
      });
    }

    $scope.devices = [];

    $scope.templateChange = function() {
      getByTemplate($scope.template.id);
    };

    Template.getAll().then(function(res) {
      $scope.templates = res.data;
      if ($scope.templates.length > 0) {
        $scope.template = $scope.templates[0];
        getByTemplate($scope.templates[0].id);
      }
    }, function(err) {
      alert('errror');
    });


  }
]);
