(function($) {
  $(document).ready(function(){
    ReactRouter.run(Routes, ReactRouter.HistoryLocation, function(Handler) {
      var templatePanel = document.getElementById('template-panel');
      React.render(<Handler />, templatePanel);
    });
  });
}).call(document, jQuery);
