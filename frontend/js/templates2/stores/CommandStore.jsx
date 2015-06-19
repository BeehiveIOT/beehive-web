(function() {
  var actions = {
    COMMANDS_LOADED: 'commandsLoaded',
    COMMAND_READ: 'commandRead',
    COMMAND_CREATED: 'commandCreated',
    COMMAND_UPDATED: 'commandUpdated',
    COMMAND_DELETED: 'commandDeleted',
    ARGUMENT_CREATED: 'argumentCreated',
    ARGUMENT_DELETED: 'argumentDeleted'
  };

  var CommandStore = Reflux.createStore({
    init: function() {
      this.commands = [];
      this.listenToMany(CommandActions);
    },
    onLoad: function(templateId) {
      var url = '/templates/' + templateId + '/commands';
      console.log('loading commands');
      $http.get(url).then(function(res) {
        this.commands = res;
        this.trigger(actions.COMMANDS_LOADED, res);
      }.bind(this), function(err){});
    },
    onGet: function(templateId, commandId) {
      var url = '/templates/' + templateId + '/commands/' + commandId;
      $http.get(url).then(function(res) {
        this.trigger(actions.COMMAND_READ, res);
      }.bind(this), function(err){});
    },
    onCreate: function(templateId, data) {
      var url = '/templates/' + templateId + '/commands';
      $http.post(url, data).then(function(res){
        this.trigger(actions.COMMAND_CREATED, res);
      }.bind(this), function(err) {});
    },
    onUpdate: function(templateId, commandId, data) {
      var url = '/templates/' + templateId + '/commands/' + commandId;
      $http.put(url, data).then(function(res) {
        this.trigger(actions.COMMAND_UPDATED, res);
      }.bind(this), function(err) {});
    },
    onRemove: function(templateId, commandId, index) {
      var url = '/templates/' + templateId + '/commands/' + commandId;
      $http.remove(url, {}).then(function(res) {
        this.commands.splice(index, 1);
        this.trigger(actions.COMMANDS_LOADED, this.commands);
      }.bind(this), function(err) {});
    },
    onCreateArgument: function(templateId, commandId, data) {
      var url = '/templates/' + templateId + '/commands/' + commandId + '/arguments';
      $http.post(url, data).then(function(res) {
        this.trigger(actions.ARGUMENT_CREATED, res);
      }.bind(this), function(err) {});
    },
    onDeleteArgument: function(templateId, commandId, argumentId, index) {
      var url = '/templates/' + templateId + '/commands/' + commandId + '/arguments/' + argumentId;
      $http.remove(url, {}).then(function(res) {
        this.trigger(actions.ARGUMENT_DELETED, index);
      }.bind(this), function(err){});
    }
  });
  window.CommandStore = CommandStore;
}).call(document);
