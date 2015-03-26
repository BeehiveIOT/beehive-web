(function($) {
  function setVisibility(reactRef, show) {
    if (show) {
      $(this.refs[reactRef].getDOMNode()).show();
    } else {
      $(this.refs[reactRef].getDOMNode()).hide();
    }
  }

  function updateDevice(device) {
    var data = this.state.device;
    for (var key in device) {
      data[key] = device[key];
    }
    DeviceActions.update(this.props.deviceId, data);
  }

  function displayEdit() {
    this.refs.deviceEdit.setDevice(this.state.device);
    setVisibility.call(this, 'deviceDetails', false);
    setVisibility.call(this, 'deviceEdit', true);
  }

  function displayDetails() {
    setVisibility.call(this, 'deviceDetails', true);
    setVisibility.call(this, 'deviceEdit', false);
  }

  DeviceInformation = React.createClass({
    mixins: [Reflux.listenTo(DeviceStore, 'onDeviceChange')],
    getInitialState: function() {
      return {
        device: {}
      };
    },
    componentDidMount: function() {
      console.log('DeviceInformation: component did mount');
      DeviceActions.load(this.props.deviceId);
      setVisibility.call(this, 'deviceDetails', false);
      setVisibility.call(this, 'deviceEdit', false);
    },
    onDeviceChange: function(action, device) {
      if (action === 'loaded') {
        this.setState({device: device});
        setVisibility.call(this, 'loading', false);
        setVisibility.call(this, 'deviceDetails', true);
      } else if (action === 'updated') {
        this.setState({device: device});
        displayDetails.call(this);
      }
    },
    render: function() {
      return (
        <div className="device-edit" ref="body">
          <div ref="loading">
            <i className="fa fa-spinner fa-spin"></i>
          </div>
          <DeviceDetails ref="deviceDetails" data={this.state.device}
            onEdit={displayEdit.bind(this)} />
          <DeviceEdit ref="deviceEdit" data={this.state.device}
            onCancel={displayDetails.bind(this)} onSave={updateDevice.bind(this)} />
        </div>
      );
    }
  });

  window.DeviceInformation = DeviceInformation;
}).call(document, jQuery);
