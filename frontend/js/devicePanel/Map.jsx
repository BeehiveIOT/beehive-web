(function(){

  function createPath() {
    var path = new google.maps.Polyline({
      path: [],
      geodesic: true,
      strokeColor: '#1B57F2',
      strokeOpacity: 1.0,
      strokeWeight: 2
    });

    return path;
  }

  var Map = React.createClass({
    getInitialState: function() {
      return {
        map: null,
        path: null
      }
    },
    addMarker: function(position, title) {
      var marker = new google.maps.Marker({
        position: position,
        map: this.state.map,
        title: title
      });
    },
    addElementToPath: function(position) {
      this.state.path.getPath().push(position);
      this.addMarker(position, "");
    },
    pushData: function(data) {
      try {
        data = JSON.parse(data);
        if (!data.lat || !data.lng) {
          return;
        }

        var position = new google.maps.LatLng(data.lat, data.lng);
        this.addElementToPath(position);
      } catch(e) {
        console.error('could not parse json');
      }
    },
    getDefaultProps: function () {
      return {
        initialMapOptions: {
          center: { lat: -16.562317701914843, lng: -65.390625},
          zoom: 6
        }
      };
    },
    componentDidMount: function() {
      var map = new google.maps.Map(this.getDOMNode(), this.props.initialMapOptions);
      var path = createPath();
      path.setMap(map);

      this.setState({map: map});
      this.setState({path: path});
    },
    render: function() {
      return (
        <div className="map-canvas" ></div>
      );
    }
  });

  window.Map = Map;
}).call(document);
