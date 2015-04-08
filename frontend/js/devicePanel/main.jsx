(function($) {
  $(document).ready(function(){
    var deviceId = document.getElementById('deviceId').value;
    var informationPanel = document.getElementById('device-information-panel');
    var dataStreamPanel = document.getElementById('data-stream-panel');
    var commandPanel = document.getElementById('command-panel');
    var executionLogPanel = document.getElementById('execution-log-panel');

    React.render(<DeviceInformation deviceId={deviceId} />, informationPanel);
    React.render(<DataStreamList deviceId={deviceId} />, dataStreamPanel);
    React.render(<CommandList deviceId={deviceId} />, commandPanel);
    React.render(<ExecutionLogList deviceId={deviceId} />, executionLogPanel);
  });
}).call(document, jQuery);
