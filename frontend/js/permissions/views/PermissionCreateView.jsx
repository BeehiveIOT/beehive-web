(function() {
  function getPermissionRows() {
    return this.state.permissions.map(function(item, index) {
      var trash = <a href="#"><i className="fa fa-trash-o"></i></a>;
      if (item.owner) {
        trash = '';
      }
      return (
        <tr>
          <td>{index+1}</td>
          <td>{item.name}</td>
          <td>{item.can_read ? 'yes' : 'no'}</td>
          <td>{item.can_update ? 'yes' : 'no'}</td>
          <td>{item.can_delete ? 'yes' : 'no'}</td>
          <td>{trash}</td>
        </tr>
      );
    }.bind(this));
  }

  var PermissionCreateView = React.createClass({
    getInitialState: function() {
      return {
        permissions: [{
          name: 'foobar', can_read: true, can_update: true, can_delete: true, owner: true
        }]
      };
    },
    componentDidMount: function() {

    },
    render: function() {
      var permissions = getPermissionRows.call(this);
      return (
        <div className="row">
          <div className="col-md-8 col-md-offset-2">
            <div className="panel panel-dark">
              <div className="panel-heading"><b>Device Permission Info</b></div>
              <div className="panel-body">
                <PermissionControl />
                <br />
                <table className="table">
                  <thead>
                    <th className="col-md-1">#</th>
                    <th className="col-md-4">Name</th>
                    <th className="col-md-2">Read</th>
                    <th className="col-md-2">Edit</th>
                    <th className="col-md-2">Execute</th>
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
