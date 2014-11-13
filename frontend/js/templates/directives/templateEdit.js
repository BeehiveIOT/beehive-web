angular.module('beehive')
.directive('templateEdit', [
  'Template',
  function(Template) {
    return {
      restrict: 'E',
      scope: {
        'model': '=?template',
        'editing': '=?editing'
      },
      transclude: true,
      templateUrl: '/partials/templates/templates/templateEdit.html',
      controller: function($scope, $element, $attrs) {
        $scope.working = false;

        $scope.$watch('model', function(newValue) {
          if (newValue !== undefined) {
            $scope.clone = {};
            angular.extend($scope.clone, $scope.model);
          }
        });

        $scope.save = function() {
          $scope.working = true;

          Template.update({
            id: $scope.clone.id,
            name: $scope.clone.name,
            description: $scope.clone.description
          }).then(function(res) {
            $scope.working = false;
            $scope.editing = false;
            // Set the parent scope object to the new updated object
            angular.copy($scope.clone, $scope.model);
          }, function(err){
            $scope.working = false;
            alert(err);
          });
        };

        $scope.cancel = function() {
          $scope.editing = false;
          $scope.working = false;

          // set clone values to default current model's values
          // necessary when cancel and edit again
          angular.extend($scope.clone, $scope.model);
        };

        $scope.removeCommand = function(index) {
          if (!confirm('Are you sure you want to delete this command?')) {
            return;
          }

          command = $scope.model.commands[index];
          Template.deleteCommand(command.id, $scope.model.id).then(function(res){
            $scope.model.commands.splice(index, 1);
          }, function(err){});
        };
      }
    };
  }
]);
