(function() {
  var Router = ReactRouter;
  var DefaultRoute = Router.DefaultRoute;
  var Link = Router.Link;
  var Route = Router.Route;
  var RouteHandler = Router.RouteHandler;
  var NotFoundRoute = Router.NotFoundRoute;

  var routes = (
    <Route name="app" path="/dashboard/permissions" handler={App}>
      <Route name="deviceList" handler={DeviceListView} />
      <Route name="permissionCreate" path=":deviceId/edit" handler={PermissionCreateView} />

      <DefaultRoute handler={DeviceListView} />
      <NotFoundRoute handler={DeviceListView}/>
    </Route>
  );

  window.Routes = routes;
}).call(document);
