(function() {
  window.DataStreamModelActions = Reflux.createActions([
    'load',
    'update',
    'create',
  ]);
  window.DataStreamListActions = Reflux.createActions([
    'load',
    'remove'
  ]);
}).call();
