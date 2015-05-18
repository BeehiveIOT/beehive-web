(function() {
  var Link = ReactRouter.Link;

  function getDeviceRows() {
    return this.state.devices.map(function(item, index) {
      var params = {deviceId: item.id};
      return (
        <tr>
          <td>{index+1}</td>
          <td>{item.name}</td>
          <td>
            <Link to="permissionCreate" params={params} className="btn btn-light">
              <i className="fa fa-lock"></i>
            </Link>
          </td>
        </tr>
      );
    }.bind(this));
  }

  function getTemplateOptions() {
    return this.state.templates.map(function(item, index) {
      return (
        <option value={item.id}>{item.name}</option>
      );
    }.bind(this));
  }

  function onTemplateChange(e) {
    DeviceActions.loadByTemplate(e.currentTarget.value);
  }


  var DeviceListView = React.createClass({
    mixins: [
      Reflux.listenTo(window.TemplateCollectionStore, 'onTemplateCollectionChange'),
      Reflux.listenTo(window.DeviceCollectionStore, 'onDeviceCollectionChange'),
    ],
    onDeviceCollectionChange: function(devices) {
      this.setState({devices: devices});
    },
    onTemplateCollectionChange: function(templates) {
      this.setState({templates: templates});
      if (templates.length > 0) {
        DeviceActions.loadByTemplate(templates[0].id);
      }
    },
    getInitialState: function() {
      return {
        templates: [],
        devices: []
      }
    },
    componentDidMount: function() {
      TemplateActions.load();
    },
    render: function() {
      var templates = getTemplateOptions.call(this);
      var devices = getDeviceRows.call(this);
      return (
        <div className="row">
          <div className="col-md-8 col-md-offset-2">
            <div className="panel panel-dark">
              <div className="panel-heading"><b>Device Permissions</b></div>
              <div className="panel-body">
                <div className="row">
                  <div className="col-md-12">
                    <div className="form-horizontal">
                      <div className="form-group">
                        <label className="col-sm-2 control-label">Template</label>
                        <div className="col-sm-9">
                          <select className="form-control" onChange={onTemplateChange.bind(this)}>
                            {templates}
                          </select>
                        </div>
                      </div>
                    </div>
                    <table className="table">
                      <thead>
                        <th className="col-md-1">#</th>
                        <th className="col-md-5">Name</th>
                        <th className="col-md-1">Edit<br/>Permissions</th>
                      </thead>
                      <tbody>
                        {devices}
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      );
    }
  });
  window.DeviceListView = DeviceListView;
}).call(document);
