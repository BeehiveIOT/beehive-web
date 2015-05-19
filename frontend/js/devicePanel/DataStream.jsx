(function($) {
  function getDataStreamDisplay(displayType, topic) {
    switch(displayType) {
      case 'line':
        return <LineChart ref={topic} />
      case 'bar':
        return <BarChart ref={topic} />
      case 'map':
        return <Map ref={topic} />
      case 'picture':
        return <PictureChart ref={topic} />
      return <span></span>;
    }
  }
  var DataStream = React.createClass({
    pushData: function(data) {
      if (this.refs[this.props.topic]) {
        this.refs[this.props.topic].pushData(data);
      }
    },
    render: function(){
      var dataStreamDisplay = getDataStreamDisplay(this.props.dataStream.display_type, this.props.topic);
      return (
        <div>
          <h3>{this.props.dataStream.name}</h3>
          {dataStreamDisplay}
        </div>
      );
    }
  });
  window.DataStream = DataStream;
}).call(document, jQuery);
