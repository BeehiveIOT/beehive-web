(function($) {
  var ExecutionLogList = React.createClass({
    mixins: [
      Reflux.listenTo(window.ExecutionLogStore, 'onExecutionLogChange'),
    ],
    getInitialState: function() {
      return {
        logs: []
      };
    },
    onExecutionLogChange: function(logs) {
      this.setState({logs: logs});
    },
    render: function() {
      var executionLogs = this.state.logs.map(function(item) {
        var className = 'alert alert-info';
        if (item.status === 'executed') {
          className = 'alert alert-success'
        }
        return (
          <div className={className}>
            <button type="button" className="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {item.commandName} - {item.status}
          </div>
        );
      }.bind(this));
      if (executionLogs.length === 0) { executionLogs = 'No execution logs'; }

      return (
        <div>
          {executionLogs}
        </div>
      );
    }
  });
  window.ExecutionLogList = ExecutionLogList;
}).call(document, jQuery);
