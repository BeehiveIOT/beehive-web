(function($) {
  var Navigation = ReactRouter.Navigation;
  var Link = ReactRouter.Link;

  function newCommand() {
    this.transitionTo('createCommand', {templateId: this.props.template.id});
  }

  function removeCommand(e) {
    if (!confirm('Are you sure you want to delete this command?')) {
      return;
    }

    var commandId = e.currentTarget.dataset.commandId;
    var templateId = this.props.template.id;
    var index = e.currentTarget.dataset.index;

    CommandActions.delete(templateId, commandId);
  }

  function getCommandRows() {
    var commands = this.state.commands;
    var templateId = this.props.template.id;
    return commands.map(function(item, idx) {
      var params = {
        templateId: templateId,
        commandId: item.id
      }
      return (
        <tr>
          <td>{idx+1}</td>
          <td>{item.name}</td>
          <td>{item.short_cmd}</td>
          <td>
            <Link to="editCommand" className="btn btn-light" params={params}>
              <i className="fa fa-pencil"></i>
            </Link>
          </td>
          <td>
            <a href="javascript:void(0)" className="btn btn-light"
              data-command-id={item.id} data-index={idx}
              onClick={removeCommand.bind(this)}>
              <i className="fa fa-trash-o"></i>
            </a>
          </td>
        </tr>
      );
    }.bind(this));
  }

  function onCancel(){
    if (this.props.onCancel) {
      this.props.onCancel();
    }
  }

  var TemplateCommands = React.createClass({
    mixins: [
      Navigation,
      Reflux.listenTo(CommandStore, 'onCommandChange')
    ],
    onCommandChange: function(action, data) {
      if (action === 'commandsLoaded') {
        this.setState({commands: data});
        $(this.refs.spinner.getDOMNode()).hide();
      }
    },
    getInitialState: function() {
      return {
        commands: []
      };
    },
    componentDidMount: function() {
      CommandActions.load(this.props.template.id);
    },
    render: function() {
      var commands = getCommandRows.call(this);
      return (
        <div className="template-edit">
          <div className="row">
            <div className="col-md-12">
              <button type="button" className="close close-button" title="Close"
                onClick={onCancel.bind(this)}>&times;</button>
              <div className="row">
                <div className="col-md-3">
                  <h4>Commands <i className="fa fa-spinner fa-spin" ref="spinner"></i></h4>
                </div>
                <div className="col-md-4">
                  <button className="btn btn-light" onClick={newCommand.bind(this)}>
                    <i className="fa fa-plus"></i> Add new Command
                  </button>
                </div>
              </div>

              <table className="table">
                <thead>
                  <th className="col-md-2">#</th>
                  <th className="col-md-4">Name</th>
                  <th className="col-md-4">Short Command</th>
                  <th className="col-md-1">
                  </th>
                  <th className="col-md-1"></th>
                </thead>
                <tbody>
                  {commands}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      );
    }
  });
  window.TemplateCommands = TemplateCommands;
}).call(document, jQuery);
