angular.module('beehive')
.controller('DeviceCreateCtrl', [
  '$scope',
  '$location',
  'Device',
  'Template',
  function($scope, $location, Device, Template) {
    $scope.name = "";
    $scope.description = "";
    $scope.is_public = true;
    $scope.template = null;
    $scope.working = false;

    // Save device through Device service
    $scope.save = function() {
      $scope.working = true;

      Device.create({
        name: $scope.name,
        description: $scope.description,
        is_public: $scope.is_public || false,
        template_id: $scope.template.id
      }).then(function(res) {
        $location.url('/');
        $scope.working = false;
      },function(err){
        $scope.working = false;

        var message = "";
        for(var key in err.data) {
          message += err.data[key] + "<br>";
        }
        alert(message);
      });
    };


    var load = function() {
      Template.getAll().then(function(res) {
        $scope.templates = res.data;
      }, function(err) {
      });
    };
    load();
  }
]);
