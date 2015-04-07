(function($) {
  var CommandList = React.createClass({
    mixins: [
      Reflux.listenTo(window.CommandStore, 'onCommandChange'),
    ],
    getInitialState: function() {
      return {
        commands: []
      };
    },
    onCommandChange: function(action, commands) {
      if (action === 'loaded') {
        this.setState({commands: commands});
      }
    },
    render: function() {
      var commands = this.state.commands.map(function(item) {
        return <Command command={item} deviceId={this.props.deviceId} />
      }.bind(this));
      return (<div>{commands}</div>);
    }
  });

  window.CommandList = CommandList;
}).call(document, jQuery);
