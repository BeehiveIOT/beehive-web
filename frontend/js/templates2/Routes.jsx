(function() {
  var Router = ReactRouter;
  var DefaultRoute = Router.DefaultRoute;
  var Link = Router.Link;
  var Route = Router.Route;
  var RouteHandler = Router.RouteHandler;
  var NotFoundRoute = Router.NotFoundRoute;

  var routes = (
    <Route name="app" path="/dashboard/templates" handler={App}>
      <Route name="list" handler={ListView} />
      <Route name="create" handler={CreateView} />
      <Route name="createCommand" path=":templateId/commands/create" handler={CreateCommandView} />
      <Route name="editCommand" path=":templateId/commands/:commandId" handler={CreateCommandView} />
      <DefaultRoute handler={ListView} />
      <NotFoundRoute handler={ListView}/>
    </Route>
  );

  window.Routes = routes;
}).call(document);
