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
      case 'static':
        return <StaticValue ref={topic} />
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
      var dataStream = this.props.dataStream,
        dataStreamDisplay = getDataStreamDisplay(dataStream.display_type, dataStream.topic),
        units = <span className="stream-unit">
          {dataStream.unit ? '[' + dataStream.unit + ']' : ''}
        </span>;

      return (
        <div className="static-text-view">
          <p className="stream-name">
            {this.props.dataStream.name}
            &nbsp;
            {units}
          </p>
          {dataStreamDisplay}
        </div>
      );
    }
  });
  window.DataStream = DataStream;
}).call(document, jQuery);
