(function($){
  var DeviceDetails = React.createClass({
    componentDidMount: function() {
      console.log('DeviceDetails: component did mount', this.props.data);
    },
    editHandler: function() {
      this.props.onEdit();
    },
    render: function() {
      var privacy;
      if (this.props.data.is_public) {
        privacy = <span ref="privacy">(Public Device)</span>
      } else {
        privacy = <span ref="privacy">(Private Device)</span>
      }
      return (
        <div>
          <div ref="loaded">
            <h4><b>{this.props.data.name}</b>
            &nbsp;
            {privacy}
            </h4>
            <table>
              <tr>
                <td><b>Serial Number</b></td>
                <td>{this.props.data.serial_number}</td>
              </tr>
              <tr>
                <td><b>Device Secret</b>&nbsp;&nbsp;</td>
                <td>{this.props.data.device_secret}</td>
              </tr>
              <tr>
                <td><b>MQTT-PUB Key</b>&nbsp;&nbsp;</td>
                <td>{this.props.data.pub_key}</td>
              </tr>
              <tr>
                <td><b>MQTT-SUB Key</b>&nbsp;&nbsp;</td>
                <td>{this.props.data.sub_key}</td>
              </tr>
            </table>
            <button title="Edit" className="btn btn-light edit"
              onClick={this.editHandler}> <i className="fa fa-pencil"></i>
            </button>
          </div>
        </div>
      );
    }
  });
  window.DeviceDetails = DeviceDetails;
}).call(document, jQuery);
