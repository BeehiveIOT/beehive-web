(function() {
  var Navigation = ReactRouter.Navigation;
  var State = ReactRouter.State;
  var Link = ReactRouter.Link;

  function commandTypeChange(e) {
    var value = e.currentTarget.value;
    this.setState({cmd_type: value});
  }

  function argumentTypeChange(e) {
    var value = e.currentTarget.value;
    this.setState({arg_type: value});
  }

  function getCommandPlaceholder() {
    var cmd_type = this.state.cmd_type;
    switch(cmd_type) {
      case 'string': return 'e.g. lights_on';
      case 'int': return 'e.g. 42';
    }
    return '';
  }

  function getCommandData() {
    var data = {
      name: this.refs.name.getDOMNode().value,
      short_cmd: this.refs.short_cmd.getDOMNode().value,
      type: this.refs.cmd_type.getDOMNode().value,
      arguments: this.state.arguments
    };

    return data;
  }

  function isValidCommand(data){
    if (!data.name || !data.short_cmd || !data.type) {
      return false;
    }
    if (data.type !== 'string' && data.type !== 'int') {
      return false;
    }
    return true;
  }

  function saveCommand() {
    var data = getCommandData.call(this);
    var templateId = this.getParams().templateId;
    var commandId = this.getParams().commandId;

    if (isValidCommand(data)) {
      if (!commandId) {
        CommandActions.create(templateId, data);
      } else {
        CommandActions.update(templateId, commandId, data);
      }

      this.refs.btnSave.getDOMNode().disabled = true;
      $(this.refs.spinner.getDOMNode()).show();
    }
  }

  function isValidArgument(data) {
    if (!data.name || !data.type) {
      return false;
    }
    if (((!data.minimum || !data.maximum) &&
        data.type === 'number')) {
      return false;
    }
    var min = parseFloat(data.minimum), max = parseFloat(data.maximum);
    if (min > max) {
      return false;
    }

    return true;
  }

  function getNewArgumentData() {
    var defaultValue = null, maxValue = null, minValue = null;
    var argName = this.refs.arg_name.getDOMNode().value;
    var argType = this.refs.arg_type.getDOMNode().value;
    if (argType === 'number') {
      maxValue = this.refs.arg_max.getDOMNode().value;
      minValue = this.refs.arg_min.getDOMNode().value;
    } else if (argType === 'string') {
      defaultValue = this.refs.arg_default.getDOMNode().value || null;
    }

    var data = {
      name: argName, type: argType,
      default: defaultValue, maximum: maxValue, minimum: minValue
    };

    return data;
  }

  function cleanArgumentFields() {
    this.refs.arg_name.getDOMNode().value = '';
    if (this.refs.arg_type.getDOMNode().value === 'string') {
      this.refs.arg_default.getDOMNode().value = '';
    } else {
      this.refs.arg_max.getDOMNode().value = '';
      this.refs.arg_min.getDOMNode().value = '';
    }
    this.setState({arg_type: 'string'});
  }

  function addArgument() {
    var arguments = this.state.arguments;
    var commandId = this.getParams().commandId;
    var templateId = this.getParams().templateId;
    data = getNewArgumentData.call(this);

    if (isValidArgument(data)) {
      if (commandId) {
        CommandActions.createArgument(templateId, commandId, data);
      } else {
        arguments.push(data);
        this.setState({arguments: arguments});
      }
      cleanArgumentFields.call(this);
    }
  }

  function removeArgument(e) {
    var argumentId = e.currentTarget.dataset.argumentId;
    var index = e.currentTarget.dataset.index;
    var commandId = this.getParams().commandId;
    var templateId = this.getParams().templateId;

    if (argumentId) {
      CommandActions.deleteArgument(templateId, commandId, argumentId, index);
    } else {
      var arguments = this.state.arguments;
      arguments.splice(index, 1);
      this.setState({arguments: arguments});
    }
  }

  function getArguments() {
    return this.state.arguments.map(function(item, idx) {
      return (
        <tr>
          <td>{idx+1}</td>
          <td>{item.name}</td>
          <td>{item.type}</td>
          <td>{item.default}</td>
          <td>{item.minimum}</td>
          <td>{item.maximum}</td>
          <td>
            <a href="javascript:(0)" data-argument-id={item.id} data-index={idx} onClick={removeArgument.bind(this)}>
              <i className="fa fa-trash-o"></i>
            </a>
          </td>
        </tr>
      );
    }.bind(this));
  }

  function getArgumentValues() {
    var argumentValues = '';
    if (this.state.arg_type === 'string') {
      return (
        <div className="col-md-3">
          <label>Default Value</label>
          <input type="text" ref="arg_default" className="form-control"
            placeholder="" autocomplete="off" />
        </div>
      );
    }
    if (this.state.arg_type === 'number') {
      return (
        <div>
          <div className="col-md-2">
            <label>Min. Value</label>
            <input type="number" className="form-control" ref="arg_min" />
          </div>
          <div className="col-md-2">
            <label>Max. Value</label>
            <input type="number" className="form-control" ref="arg_max" />
          </div>
        </div>
      );
    }

    return '';
  }

  var CreateCommandView = React.createClass({
    mixins: [
      Navigation,
      State,
      Reflux.listenTo(CommandStore, 'onCommandChange')
    ],
    onCommandChange: function(action, data) {
      if (action === 'commandCreated') {
        this.transitionTo('app');
      } else if (action === 'commandUpdated') {
        this.refs.name.getDOMNode().value = data.name;
        this.refs.short_cmd.getDOMNode().value = data.short_cmd;
        this.setState({ cmd_type: data.cmd_type });
        $(this.refs.spinner.getDOMNode()).hide();
        this.refs.btnSave.getDOMNode().disabled = false;
      } else if (action === 'commandRead') {
        this.refs.name.getDOMNode().value = data.name;
        this.refs.short_cmd.getDOMNode().value = data.short_cmd;
        this.setState({arguments: data.arguments, cmd_type: data.cmd_type });
      } else if (action === 'argumentCreated') {
        var arguments = this.state.arguments;
        arguments.push(data);
        this.setState({ arguments: arguments });
      } else if (action === 'argumentDeleted') {
        var arguments = this.state.arguments;
        arguments.splice(data, 1);
        this.setState({arguments: arguments});
      }
    },
    getInitialState: function() {
      return {
        cmd_type: 'string',
        arg_type: 'string',
        arguments: []
      };
    },
    componentDidMount: function() {
      var templateId = this.getParams().templateId;
      var commandId = this.getParams().commandId;
      console.log('commandId', commandId);
      if (commandId) {
        CommandActions.get(templateId, commandId);
      }
      $(this.refs.spinner.getDOMNode()).hide();
    },
    render: function() {
      var argumentValues = getArgumentValues.call(this);
      var commandPlaceholder = getCommandPlaceholder.call(this);
      var arguments = getArguments.call(this);
      return (
        <div className="row">
          <div className="col-md-6 col-md-offset-3">
            <div className="panel panel-dark">
              <div className="panel-heading"><b>Command Information</b></div>
              <div className="panel-body">
                <div className="form-group">
                  <label>Name</label>
                  <input type="text" ref="name" className="form-control"
                    placeholder="e.g. Turn light On" autocomplete="off" />
                </div>
                <div className="row">
                  <div className="col-md-6">
                    <label>Command</label>
                    <input type=":typeSettings[cmd_type].control:" ref="short_cmd"
                      className="form-control" autocomplete="off"
                      placeholder={commandPlaceholder} />
                  </div>
                  <div className="col-md-6">
                    <label>Command Type</label>
                    <select className="form-control" ref="cmd_type"
                      value={this.state.cmd_type} onChange={commandTypeChange.bind(this)}>
                      <option value="int">Integer</option>
                      <option value="string">String</option>
                    </select>
                  </div>
                </div>
                <h4>Arguments</h4>
                <div className="row argument">
                  <div
                   className="col-md-3">
                    <label>Argument Name</label>
                    <input type="text" ref="arg_name" className="form-control"
                      placeholder="e.g. Intensity" autocomplete="off" />
                  </div>
                  <div className="col-md-3">
                    <label>Type</label>
                    <select ref="arg_type" className="form-control"
                      value={this.state.arg_type} onChange={argumentTypeChange.bind(this)}>
                      <option value="string">String</option>
                      <option value="number">Number</option>
                    </select>
                  </div>
                  {argumentValues}
                  <div className="col-md-1">
                    <br />
                    <button title="Add Argument" className="btn btn-light" onClick={addArgument.bind(this)}>
                      <i className="fa fa-plus"></i>
                    </button>
                  </div>
                </div>
                <br />
                <button className="btn btn-light" ref="btnSave" onClick={saveCommand.bind(this)} >
                  <i className="fa fa-spinner fa-spin" ref="spinner"></i>
                  Save Changes
                </button>
                &nbsp;&nbsp;&nbsp;
                <Link to='app' title="Cancel">Cancel</Link><br/><br/>
                <b>Argument List</b>
                <table className="table table-condensed">
                  <thead>
                    <th className="col-md-1">#</th>
                    <th>Argument Name</th>
                    <th>Argument Type</th>
                    <th>Default</th>
                    <th>Minimum</th>
                    <th>Maximum</th>
                    <th></th>
                  </thead>
                  <tbody>
                    {arguments}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      );
    }
  });
  window.CreateCommandView = CreateCommandView;
}).call(document);
