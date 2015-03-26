(function($) {
  $(document).ready(function(){
    var informationPanel = document.getElementById('device-information-panel');
    var dataStreamPanel = document.getElementById('data-stream-panel');
    var deviceId = document.getElementById('deviceId').value;
    React.render(<DeviceInformation deviceId={deviceId} />, informationPanel);
    // React.render(<DataStreamList deviceId={deviceId} />, dataStreamPanel);
  });
}).call(document, jQuery);
