(function($) {
  $(document).ready(function(){
    var deviceId = document.getElementById('deviceId').value;
    var informationPanel = document.getElementById('device-information-panel');
    var dataStreamPanel = document.getElementById('data-stream-panel');
    React.render(<DeviceInformation deviceId={deviceId} />, informationPanel);
    React.render(<DataStreamList deviceId={deviceId} />, dataStreamPanel);
  });
}).call(document, jQuery);
