(function() {
  window.ExecutionLogStore = Reflux.createStore({
    init: function() {
      this.listenToMany(ExecutionLogActions);
      this.executionLog = {};
    },
    onSaveCommandExecution: function(item) {
      this.executionLog[item.timestamp]
      if (this.executionLog[item.timestamp]) {
        this.executionLog[item.timestamp].status = item.status;
      } else {
        this.executionLog[item.timestamp] = {
          'commandId' : item.commandId,
          'commandName' : item.commandName,
          'status': item.status
        }
      }

      var logs = [];
      for(var key in this.executionLog) {
        logs.push(this.executionLog[key]);
      }

      this.trigger(logs);
    },
  });
}).call(document);
