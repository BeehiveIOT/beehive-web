angular.module('beehive')
.controller('TemplateCreateCtrl', [
  '$scope',
  '$location',
  'Template',
  function($scope, $location, Template){
    $scope.working = false;
    $scope.editing = false;

    $scope.save = function() {
      $scope.working = true;

      Template.create({
        name: $scope.name,
        description: $scope.description
      }).then(function(res){
        $scope.working = false;
        $location.url('/');
      }, function(err){
        $scope.working = false;
        alert(JSON.stringify(err.data));
      });
    };
  }
]);
