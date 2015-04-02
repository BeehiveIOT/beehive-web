(function($) {
    // mixins: [
    //   Reflux.listenTo(DeviceStore, 'onDeviceChange'),
    //   Reflux.listenTo(DataStreamStore, 'onReceiveMessage'),
    //   Reflux.listenTo(DataStreamInfoStore, 'onDataStreamInfoChange'),
    // ],
    //
  var DataStreamList = React.createClass({
    mixins: [
      Reflux.listenTo(window.DeviceStore, 'onDeviceChange'),
      Reflux.listenTo(window.DataStreamStore, 'onReceiveMessage'),
      Reflux.listenTo(window.DataStreamInfoStore, 'onDataStreamInfoChange'),
    ],
    getInitialState: function() {
      this.foobar = {};
      return {
        dataStreams: [],
        pubKey: ''
      };
    },
    componentDidMount: function() {
      DataStreamActions.load(this.props.deviceId);
    },
    onReceiveMessage: function(res) {
      if (this.refs[res.topic]) {
        this.refs[res.topic].pushData(res.data);
      }
    },
    onDeviceChange: function(action, device){
      if (action === 'loaded') {
        this.setState({pubKey: device.pub_key,}, false);
      }
    },
    onDataStreamInfoChange: function(dataStreams) {
      this.setState({dataStreams: dataStreams});
    },
    render: function() {
      var dataStreams = this.state.dataStreams.map(function(item) {
        var topic = this.state.pubKey + '/' + item.topic_name
        DataStreamActions.subscribe(topic);

        return <DataStream dataStream={item} topic={topic} ref={topic} />;
      }.bind(this));
      return (
        <div>
          {dataStreams}
        </div>
      );
    }
  });
  window.DataStreamList = DataStreamList;
}).call(document, jQuery);
