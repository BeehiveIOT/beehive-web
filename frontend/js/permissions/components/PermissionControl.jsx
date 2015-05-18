(function() {

  function addPermission(e) {
    alert('foo');
  }

  var PermissionControl = React.createClass({
    render: function() {
      return (
        <div className="row">
          <div className="col-md-4">
            <label>
              Username
              <input className="form-control" />
            </label>
          </div>
          <div className="col-md-2">
            <label>
              Read
              <input className="form-control" type="checkbox" />
            </label>
          </div>
          <div className="col-md-2">
            <label>
              Edit&nbsp;&nbsp;
              <input className="form-control" type="checkbox" />
            </label>
          </div>
          <div className="col-md-2">
            <label>
              Execute
              <input className="form-control" type="checkbox" />
            </label>
          </div>
          <div className="col-md-2">
            <br />
            <button className="btn btn-light" onClick={addPermission.bind(this)}>
              <i className="fa fa-plus"></i>
            </button>
          </div>
        </div>
      );
    }
  });
  window.PermissionControl = PermissionControl;
}).call(document);
