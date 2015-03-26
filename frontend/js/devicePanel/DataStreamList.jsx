(function($) {
  function loadDataStreams() {

  }
  var DataStreamList = React.createClass({
    componentDidMount: function() {

    },
    render: function() {
      return (
        <div>
          <DataStream />
          <DataStream />
        </div>
      );
    }
  });
  window.DataStreamList = DataStreamList;
}).call(document, jQuery);
