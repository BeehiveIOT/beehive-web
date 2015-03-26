(function($) {

  var DataStream = React.createClass({
    render: function(){
      return (
        <div>
          <h3>Chart X</h3>
          <LineChart updateInterval="1000" />
        </div>
      );
    }
  });
  window.DataStream = DataStream;
}).call(document, jQuery);
