(function() {
  var State = ReactRouter.State;

  function onPermissionAdded(data) {
    var deviceId = this.getParams().deviceId;
    PermissionActions.addPermission(deviceId, data);
  }

  function onRemovePermission(e) {
    if (!confirm('Are you sure to remove this record?')) {
      return;
    }

    var deviceId = this.getParams().deviceId,
      userId = e.currentTarget.dataset.userId;

    PermissionActions.removePermission(deviceId, userId);
  }

  function getPermissionRows() {
    return this.state.permissions.map(function(item, index) {
      var trash = (<a href="javascript:void(0)" data-user-id={item.user_id} onClick={onRemovePermission.bind(this)} >
        <i className="fa fa-trash-o"></i></a>);

      if (item.owner) {
        trash = '';
      }
      return (
        <tr>
          <td>{index+1}</td>
          <td>{item.name}</td>
          <td>{item.username}</td>
          <td>{item.can_read ? 'yes' : 'no'}</td>
          <td>{item.can_edit ? 'yes' : 'no'}</td>
          <td>{item.can_execute ? 'yes' : 'no'}</td>
          <td>{trash}</td>
        </tr>
      );
    }.bind(this));
  }

  var PermissionCreateView = React.createClass({
    mixins: [
      State,
      Reflux.listenTo(DevicePermissionStore, 'onDevicePermissionChange')
    ],
    onDevicePermissionChange: function(data) {
      this.setState({permissions:data});
    },
    getInitialState: function() {
      return {
        permissions: []
      };
    },
    componentDidMount: function() {
      var deviceId = this.getParams().deviceId;
      PermissionActions.loadPermissionsByDevice(deviceId);
    },
    render: function() {
      var permissions = getPermissionRows.call(this);
      return (
        <div className="row">
          <div className="col-md-8 col-md-offset-2">
            <div className="panel panel-dark">
              <div className="panel-heading"><b>Device Permission Info</b></div>
              <div className="panel-body">
                <PermissionControl onPermissionAdded={onPermissionAdded.bind(this)} />
                <br />
                <table className="table">
                  <thead>
                    <th className="col-md-1">#</th>
                    <th className="col-md-4">Name</th>
                    <th className="col-md-3">Username</th>
                    <th className="col-md-1">Read</th>
                    <th className="col-md-1">Edit</th>
                    <th className="col-md-1">Execute</th>
                    <th className="col-md-1"></th>
                  </thead>
                  <tbody>
                    {permissions}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      );
    }
  });
  window.PermissionCreateView = PermissionCreateView;
}).call(document);
