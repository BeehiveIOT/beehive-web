(function() {
  var PermissionCreateView = React.createClass({
    render: function() {
      return (
        <div className="row">
          <div className="col-md-8 col-md-offset-2">
            <div className="panel panel-dark">
              <div className="panel-heading"><b>Device Permission Info</b></div>
              <div className="panel-body">
              </div>
            </div>
          </div>
        </div>
      );
    }
  });
  window.PermissionCreateView = PermissionCreateView;
}).call(document);
