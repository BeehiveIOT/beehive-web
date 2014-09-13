angular.module('beehive')
.directive('deviceEdit', [
  'Device',
  function(Device) {
    return {
      restrict: 'E',
      scope: {
        model: '=model'
      },
      transclude: true,
      templateUrl: '/partials/devices/templates/deviceEdit.html',
      controller: function($scope, $element, $attrs) {
        $scope.edition = false;
        $scope.working = false;
        $scope.$watch('model', function(newValue) {
          if (newValue !== undefined) {
            $scope.clone = {};
            angular.extend($scope.clone, $scope.model);
          }
        });

        $scope.save = function() {
          $scope.working = true;

          // Update device information
          Device.update({
            id: $scope.clone.id,
            name: $scope.clone.name,
            description: $scope.clone.description,
            is_public: $scope.clone.is_public

          }).then(function(res) {
            $scope.working = false;
            $scope.edition = false;
            angular.copy($scope.clone, $scope.model);
          }, function(err) {
            $scope.working = false;
            $scope.edition = false;
            var message = "";
            for(var key in err.data) {
              message += err.data[key] + "<br>";
            }
            alert(message);
          });
        };

        $scope.edit = function() {
          $scope.edition = true;
          angular.extend($scope.clone, $scope.model);
        };

      }
    };
  }
]);
