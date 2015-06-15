(function($) {
  function getDataStreamDisplay(displayType, topic) {
    switch(displayType) {
      case 'line':
        return <LineChart ref="chart" />
      case 'bar':
        return <BarChart ref="chart" />
      case 'map':
        return <Map ref="chart" />
      case 'picture':
        return <PictureChart ref="chart" />
      case 'static':
        return <StaticValue ref="chart"/>
      return <span></span>;
    }
  }
  var DataStream = React.createClass({
    pushData: function(data) {
      if (this.refs['chart']) {
        this.refs['chart'].pushData(data);
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
