(function() {
  window.CommandStore = Reflux.createStore({
    init: function() {
      this.listenToMany(CommandActions);
      this.commands = [];
      this.commandExecution = {};
    },
    onLoad: function(deviceId) {
      $http.get('/devices/' + deviceId + '/commands').then(function(res) {
        this.commands = res;
        this.trigger('loaded', this.commands);
      }.bind(this), function(err) {})
    },
    onSetCommands: function(commands) {
      this.commands = commands;
      this.trigger('loaded', this.commands);
    },
    onExecute: function(commandId, deviceId, data) {
      var arguments = {arguments: data};
      var url = '/devices/' + deviceId + '/commands/' + commandId + '/execute';
      $http.post(url, arguments).then(function(res) {
        console.log('command:',res.command_id, 'timestamp', res.timestamp);
      }, function(err){});
    }
  });
}).call(document);
