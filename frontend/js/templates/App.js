angular.module('beehive', [
  'ngRoute'
])
.config(['$routeProvider', function($routeProvider) {
  $routeProvider
  .when('/', {
    templateUrl: '/partials/templates/list.html',
    controller: 'TemplateListCtrl'
  })
  .when('/create', {
    templateUrl: '/partials/templates/create.html',
    controller: 'TemplateCreateCtrl'
  })
  .when('/:templateId/commands', {
    templateUrl: '/partials/templates/commands/edit.html',
    controller: 'CommandEditCtrl'
  })
  .when('/:templateId/commands/:commandId', {
    templateUrl: '/partials/templates/commands/edit.html',
    controller: 'CommandEditCtrl'
  })
  .otherwise({
    redirectTo: '/'
  });
}]);
