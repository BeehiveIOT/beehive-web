angular.module('beehive')
.factory('Template', [
  '$http',
  function($http) {
    return {
      getAll: function() {
        return $http.get('/templates/json');
      },
      get: function(templateId) {
        return $http.get('/templates/'+templateId);
      },
      update: function(data) {
        return $http.put('/templates/'+data.id, data);
      },
      create: function(data) {
        return $http.post('/templates', data);
      },
      delete: function(templateId) {
        return $http.delete('/templates/'+templateId);
      },
      getCommand: function(commandId, templateId) {
        return $http.get('/templates/'+templateId+'/commands/'+commandId);
      },
      createCommand: function(command, templateId) {
        return $http.post('/templates/'+templateId+'/commands', command);
      },
      updateCommand: function(command, templateId) {
        return $http.put('/templates/'+templateId+'/commands/'+command.id);
      },
      deleteCommand: function(commandId, templateId) {
        return $http.delete('/templates/'+templateId+'/commands/'+command.id);
      },
      createArgument: function(commandId, data) {
        return $http.post('/commands/'+commandId+'/arguments', data);
      },
      deleteArgument: function(commandId, argumentId) {
        return $http.delete('/commands/'+commandId+'/arguments/'+argumentId);
      }
    };
  }
]);
