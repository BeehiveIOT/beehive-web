angular.module('beehive')
.factory('Template', [
  '$http',
  function($http) {
    return {
      getAll: function() {
        return $http.get('/templates/json');
      }
    };
  }
]);
