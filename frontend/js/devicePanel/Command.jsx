(function($) {
  var Command = React.createClass({
    componentDidMount: function() {
      $(this.refs.arguments.getDOMNode()).hide();
    },
    displayArguments: function() {
      $(this.refs.arguments.getDOMNode()).show();
    },
    hideArguments: function() {
      $(this.refs.arguments.getDOMNode()).hide();
    },
    execute: function() {
      var arguments = this.props.command.arguments, value;
      var result = [];
      for(var i = 0; i < arguments.length; ++i) {
        value = this.refs['argument-'+arguments[i].id].getDOMNode().value;
        result.push({argument_id: arguments[i].id, value: value});
      }

      CommandActions.execute(this.props.command.id, this.props.deviceId, result);
      this.hideArguments();
    },
    render: function() {
      var arguments = this.props.command.arguments.map(function(item) {
        var placeholder = '', defaultValue = '', ref = 'argument-' + item.id;
        if (item.type === 'number') {
          placeholder = 'Range: ['+item.minimum+','+item.maximum+']'
        } else if (item.type === 'string') {
          placeholder = 'Enter a string'
          if (item['default']) {
            defaultValue = item['default'];
          }
        }

        return (
          <div className="form-group">
            <label>{item.name}</label>
            <input type="text" className="form-control" ref={ref}
              placeholder={placeholder} defaultValue={defaultValue} />
          </div>
        );
      });
      if (arguments.length === 0) {
        arguments = <p>No arguments needed</p>
      }
      return (
        <div className="command">
          <div className="row">
            <div className="col-sm-12">
              <p className="form-control-static">
                {this.props.command.name}
                &nbsp;
                <a href="javascript: void(0)" onClick={this.displayArguments}>
                  <i className="fa fa-eye"></i>
                </a>
              </p>
            </div>
          </div>
          <div className="row" ref="arguments">
            <div className="col-sm-12">
              <div role="form">
                {arguments}
                <button className="btn btn-light" onClick={this.execute}>Execute</button>
                &nbsp;&nbsp;&nbsp;
                <a href="javascript:void(0)" onClick={this.hideArguments}>Cancel</a>
              </div>
            </div>
          </div>
        </div>
      );
    }
  });
  window.Command = Command;
}).call(document, jQuery);
