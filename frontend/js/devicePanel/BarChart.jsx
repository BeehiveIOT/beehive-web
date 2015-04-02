(function($){
  var BarChart = React.createClass({
    getInitialState: function() {
      var id = 'BarChart-' + (Math.random()+'').substring(2, 5);
      this.chartData = [];
      this.count = 0;
      return {
        id: id,
        chart: null
      };
    },
    pushData: function(data) {
      if (!data) { return; }

      if (this.chartData.length > 10) {
        this.chartData = this.chartData.slice(1);
      }
      this.chartData.push([this.count, data]);
      this.count++;

      this.state.chart.setData([{data: this.chartData, bars: {show: true}}]);
      this.state.chart.setupGrid();
      this.state.chart.draw();
    },
    componentDidMount: function() {
      var id = '#' + this.state.id;
      var chart = this.refs.chart.getDOMNode();
      $(chart).height(300);

      var plot = $.plot(id, [{
        data: this.chartData,
        bars: { show: true }
      }], {
        xaxis: { show: false }
      });

      this.setState({ chart: plot });
    },
    render: function() {
      return (
        <div className="demo-container">
          <div ref="chart" id={this.state.id} className="demo-placeholder"></div>
        </div>
      );
    }
  });

  window.BarChart = BarChart;
}).call(document, jQuery);
