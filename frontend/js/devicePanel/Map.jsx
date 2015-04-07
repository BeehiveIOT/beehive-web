(function($){
  function createPath() {

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
        console.log(data);
        var position = new google.maps.LatLng(data.lat, data.lng);
        this.addElementToPath(position);
      } catch(e) {
        console.error('could not parse json');
      }
    },
    createPath: function() {
      var flightPath = new google.maps.Polyline({
        path: [],
        geodesic: true,
        strokeColor: '#1B57F2',
        strokeOpacity: 1.0,
        strokeWeight: 2
      });

      flightPath.setMap(this.state.map);

      return flightPath;
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
      // var marker = new google.maps.Marker({position: this.mapCenterLatLng(), title: 'Hi', map: map});
      this.setState({map: map});
      this.setState({path:this.createPath()});
    },
    render: function() {
      return (
        <div className="map-canvas" ></div>
      );
    }
  });

  window.Map = Map;
}).call(document, jQuery);


/*
var ExampleGoogleMap = React.createClass({
    getDefaultProps: function () {
        return {
            initialZoom: 8,
            mapCenterLat: 43.6425569,
            mapCenterLng: -79.4073126,
        };
    },
    componentDidMount: function (rootNode) {
        var mapOptions = {
            center: this.mapCenterLatLng(),
            zoom: this.props.initialZoom
        },
        map = new google.maps.Map(this.getDOMNode(), mapOptions);
        var marker = new google.maps.Marker({position: this.mapCenterLatLng(), title: 'Hi', map: map});
        this.setState({map: map});
    },
    mapCenterLatLng: function () {
        var props = this.props;
        return new google.maps.LatLng(props.mapCenterLat, props.mapCenterLng);
    },
    render: function () {
        return (
          <div className='map-gic'></div>
        );
    }
});
 */
