(function() {
  var RouteHandler = ReactRouter.RouteHandler;

  var App = React.createClass({
    render: function() {
      return (
        <RouteHandler />
      );
    }
  });
  window.App = App;
}).call(document);
