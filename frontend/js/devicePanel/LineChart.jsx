(function($) {

  function getRandomData() {
  var data = [], totalPoints = 300;
    if (data.length > 0){
      data = data.slice(1);
    }

    // Do a random walk
    while (data.length < totalPoints) {
      var prev = data.length > 0 ? data[data.length - 1] : 50,
        y = prev + Math.random() * 10 - 5;
      if (y < 0) {
        y = 0;
      } else if (y > 100) {
        y = 100;
      }
      data.push(y);
    }

    // Zip the generated y values with the x values
    var res = [];
    for (var i = 0; i < data.length; ++i) {
      res.push([i, data[i]])
    }

    return res;
  }

  function update(plot, updateInterval) {
    plot.setData([getRandomData()]);
    // Since the axes don't change, we don't need to call plot.setupGrid()
    plot.draw();
    setTimeout(function() {
      update(plot, updateInterval);
    }, updateInterval);
  }

  var LineChart = React.createClass({
    getInitialState: function() {
      var id = 'LineChart-' + (Math.random()+'').substring(2, 5);
      return {
        id: id
      };
    },
    componentDidMount: function() {
      var id = '#' + this.state.id;
      var chart = this.refs.chart.getDOMNode();
      $(chart).height(300);
      var plot = $.plot(id, [ getRandomData.call(this) ], {
        series: {
          shadowSize: 0 // Drawing is faster without shadows
        },
        yaxis: {
          min: 0,
          max: 100
        },
        xaxis: {
          show: false
        },
        zoom: {
          interactive: false
        },
        pan: {
          interactive: true
        }
      });
      update.call(this, plot, this.props.updateInterval);
    },
    render: function() {
      return (
        <div id="content">
          <div className="demo-container">
            <div ref="chart" id={this.state.id} className="demo-placeholder"></div>
          </div>
        </div>
      );
    }
  });
  window.LineChart = LineChart;
}).call(this, jQuery);
