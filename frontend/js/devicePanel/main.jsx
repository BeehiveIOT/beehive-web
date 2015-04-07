(function($) {
  $(document).ready(function(){
    var deviceId = document.getElementById('deviceId').value;
    var informationPanel = document.getElementById('device-information-panel');
    var dataStreamPanel = document.getElementById('data-stream-panel');
    var commandPanel = document.getElementById('command-panel');

    React.render(<DeviceInformation deviceId={deviceId} />, informationPanel);
    React.render(<DataStreamList deviceId={deviceId} />, dataStreamPanel);
    React.render(<CommandList deviceId={deviceId} />, commandPanel);
  });
}).call(document, jQuery);
