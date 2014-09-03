angular.module('controllers', [])
.run([function(GlobalService) {}])
.controller('EditDeviceController', [
  '$scope',
  '$http',
  '$rootScope',
  '$routeParams',
  'GlobalService',
  function($scope, $http, $rootScope, $routeParams, GlobalService) {
    $scope.save = function() {
      var data = {
        name: $scope.name,
        description: $scope.description,
        communication_type: $scope.communication_type
      };
      $scope.sending = true;
      $http.put('/models/'+$scope.id, data).success(function(data){
        $rootScope.$broadcast('notify-message', 'Changes saved successfully.');
        $scope.sending = false;
      }).error(function(err) {
        $rootScope.$broadcast('notify-error', 'Error when updating device model.');
        $scope.sending = false;
      });
    };

    $rootScope.loading = true;
    var id = GlobalService.deviceId;
    $http.get('/models/'+id+'/json').success(function(data) {
      $scope.id = data.id;
      $scope.name = data.name;
      $scope.description = data.description;
      $scope.communication_types = data.communication_types;
      $scope.communication_type = data.communication_type;
      $rootScope.loading = false;
    });
  }])
.controller('CommandsController', ['$scope', '$routeParams',
  function($scope, $routeParams) {
    $scope.deviceId = $routeParams.deviceId;
  }])
.controller('CommandDetailController', ['$scope', '$routeParams','$http',
  function($scope, $routeParams, $http) {
    var commandId = parseInt($routeParams.commandId, 10);
    var deviceId = parseInt($routeParams.deviceId);
    $scope.saveEnabled = false;
    if (!commandId && !deviceId) {/*TODO: error message*/return;}
    if (!commandId && deviceId) {
      $scope.id = 0;
      $scope.name = "";
      $scope.short_cmd = "";
      $scope.device_id = deviceId;
      $scope.saveEnabled = true;
    } else {
      $http.get('/models/'+deviceId+'/commands/'+commandId)
        .success(function(data) {
          $scope.id = data.id;
          $scope.name = data.name;
          $scope.short_cmd = data.short_cmd;
          $scope.device_id = data.device_id;
          $scope.saveEnabled = true;
        })
        .error(function(err) {
        });
    }

    $scope.save = function() {
      if ($scope.id === 0) {
        var data = {
          name: $scope.name,
          short_cmd: $scope.short_cmd,
          device_id: $scope.deviceId
        };
      }
    };

    // if (id !== 0) {
    //   // TODO: get command with its arguments
    // } else {
    //   // TODO: necessary stuff for command creation
    //   var data = {
    //     name: $scope.name,
    //     short_cmd: $scope.short_cmd,
    //     device_id: deviceId,
    //   };
    //   $http.post('/models/'+deviceId+'/commands', data).success(function(data) {
    //     $scope.id = data.id;
    //     $scope.name = data.name;
    //     $scope.short_cmd = data.short_cmd;
    //   }).error(function() {});
    // }
  }]);
