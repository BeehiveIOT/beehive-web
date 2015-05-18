(function($) {
  $(document).ready(function(){
    ReactRouter.run(Routes, ReactRouter.HistoryLocation, function(Handler) {
      var permissionPanel = document.getElementById('permission-panel');
      React.render(<Handler />, permissionPanel);
    });
  });
}).call(document, jQuery);
