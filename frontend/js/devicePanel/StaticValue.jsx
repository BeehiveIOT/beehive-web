(function() {
  var StaticValue = React.createClass({
    getInitialState: function() {
      return {
        value: null
      };
    },
    pushData: function(data) {
      if (!data) { return; }

      this.setState({value: data});
    },
    render: function() {
      var value = 'No values yet';
      if (this.state.value) {
        value = this.state.value;
      }
      return (
        <p>
          <span><b>Value:</b></span> {value}
        </p>
      );
    }
  });
  window.StaticValue = StaticValue;
}).call(document);
