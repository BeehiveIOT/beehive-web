(function() {
  var PictureChart = React.createClass({
    getInitialState: function() {
      var id = 'Picture-' + (Math.random()+'').substring(2, 5);
      this.count = 0;
      return {
        id: id,
      };
    },
    pushData: function(data) {
      if (!data) { return; }
      try {
        var image = this.refs.chart.getDOMNode();
        image.src = 'data:image/jpg;base64,' + data;
      } catch(e) {
        console.log("ERROR: ", res.data, e);
      }
    },
    render: function() {
      return (
        <div className="demo-container">
          <img ref="chart" id={this.state.id} className="picture-chart" />
        </div>
      );
    }
  });
  window.PictureChart = PictureChart;
}).call(document);
