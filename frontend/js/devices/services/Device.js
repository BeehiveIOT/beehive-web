angular.module('beehive')
.factory('Device', [
  '$http',
  function ($http) {
    return {
      getAll: function() {
        return $http.get('/devices/');
      },
      get: function(deviceId) {
        return $http.get('/devices/'+deviceId);
      },
      create: function(data) {
        return $http.post('/devices', data);
      },
      update: function(data) {
        return $http.put('/devices/'+data.id, data);
      },
      getByTemplate: function(templateId) {
        if (templateId === -1) {
          return $http.get('/devices/shared');
        }

        return $http.get('/templates/' + templateId + '/devices');
      }
    };
  }
]);
