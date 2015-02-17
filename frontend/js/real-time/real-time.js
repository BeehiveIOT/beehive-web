(function($) {
  var map, path, bridge;

  function initialize() {
    var mapOptions = {
      center: { lat: -16.562317701914843, lng: -65.390625},
      zoom: 5
    };
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    path = createPath();
  }

  function addMarker(position, title) {
    console.log(position);
    var marker = new google.maps.Marker({
      position: position,
      map: map,
      title: title
    });
  }

  function createPath() {
    // new google.maps.LatLng(-16.562317, -65.390625),
    // new google.maps.LatLng(-16.662317, -65.490625),
    // new google.maps.LatLng(-16.762317, -65.590625),
    // new google.maps.LatLng(-17.162317, -65.690625),
    // new google.maps.LatLng(-16.552317, -65.790625),

    var flightPath = new google.maps.Polyline({
      path: [],
      geodesic: true,
      strokeColor: '#1B57F2',
      strokeOpacity: 1.0,
      strokeWeight: 2
    });

    flightPath.setMap(map);

    return flightPath;
  }

  function addElementToPath(position) {
    path.getPath().push(position);
    var data = {
      lat: position.lat(),
      lng: position.lng()
    };
    addMarker(position, "");
  }

  function startStreaming() {
    bridge = new BeehiveBridge({
      wsUrl: 'http://' + document.domain +':9999/echo',
      deviceKey: 'sergio'
    });

    bridge.on('connect', function() {
      console.log('TEST CONNECTED');

      bridge.subscribe('car/location', function(res) {
        try {
          var data = JSON.parse(res.data);
          console.log(data);
          var position = new google.maps.LatLng(data.lat, data.lng);
          addElementToPath(position);
        } catch(e) {
          console.log("ERROR: ", res.data, e);
        }
      });
    });

    bridge.on('error', function(err) {
      console.log('TEST ERROR', err);
    });

    bridge.connect();
  }

  function executeSingleCommand(commandId) {
    $.post('/real-time/publish-command', {
      command_id: commandId
    }).done(function(res) {
      console.log(res);
    }).fail(function(err) {
    });
  }

  function loadCommands() {
    $.get('/templates/4/commands').done(function(res){
      var commands = $('#commands');
      var tpl = '';
      for(var i = 0; i < res.length; ++i){
        tpl += '<button class="btn btn-primary" ';
        tpl += 'data-command-id="' + res[i].id + '" ';
        tpl += 'data-command="' + res[i].short_cmd + '"';
        tpl += '>' + res[i].name + '</button><br><br>';
      }
      commands.append(tpl);
    }).fail(function(err) {
      console.log(err);
    });
  }

  $(document).ready(function() {
    google.maps.event.addDomListener(window, 'load', initialize);

    startStreaming();
    loadCommands();

    $('#commands').on('click', '.btn-primary', function(e) {
      var commandId = e.currentTarget.dataset.commandId,
        shortCommand = e.currentTarget.dataset.command;
      console.log('Executing:', commandId, shortCommand);
      executeSingleCommand(commandId);
    });
  });
}).call(document, jQuery);
