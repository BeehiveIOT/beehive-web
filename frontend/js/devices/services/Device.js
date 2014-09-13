angular.module('beehive')
.factory('Device', [
  '$http',
  function ($http) {
    return {
      getAll: function() {
        return $http.get('/devices/json');
      },
      get: function(deviceId) {
        return $http.get('/devices/'+deviceId);
      },
      create: function(data) {
        return $http.post('/devices', data);
      },
      update: function(data) {
        return $http.put('/devices/'+data.id, data);
      }
    };
  }
]);
