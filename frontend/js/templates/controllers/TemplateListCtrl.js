angular.module('beehive')
.controller('TemplateListCtrl',[
  '$scope',
  'Template',
  function($scope, Template) {
    $scope.search = "";
    $scope.editing = false;

    var load = function() {
      Template.getAll().then(function(res){
        $scope.templates = res.data;
      }, function(err) {});
    };
    load();

    $scope.delete = function(index) {
      var template = $scope.templates[index];

      Template.delete(template.id).then(function(res) {
        $scope.templates.splice(index, 1);
      }, function(err){
        alert(err);
      });
    };
  }
]);
