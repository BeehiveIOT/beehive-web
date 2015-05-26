(function() {
  var Navigation = ReactRouter.Navigation;
  var Link = ReactRouter.Link;
  var State = ReactRouter.State;

  function dataTypeChange(e) {
    var value = e.currentTarget.value;
    this.setState({dataType: value});
  }

  function save() {
    var dataStreamId = this.getParams().dataStreamId;
    var templateId = this.getParams().templateId;
    $(this.refs.spinner.getDOMNode()).show();
    this.refs.btnSave.getDOMNode().disabled = true;

    var data = {
      name: this.refs.name.getDOMNode().value,
      topic_name: this.refs.topicName.getDOMNode().value,
      data_type: this.refs.dataType.getDOMNode().value,
      display_type: this.refs.displayType.getDOMNode().value,
      unit: this.refs.unit.getDOMNode().value,
      unit_symbol: this.refs.unitSymbol.getDOMNode().value
    };

    if (dataStreamId) {
      DataStreamModelActions.update(templateId, dataStreamId, data);
    } else {
      DataStreamModelActions.create(templateId, data);
    }
  }

  var DataStreamCreateView = React.createClass({
    mixins: [
      State,
      Navigation,
      Reflux.listenTo(DataStreamModelStore, 'onDataStreamChange')
    ],
    onDataStreamChange: function(data, res) {
      if (res.code === 200) {
        this.refs.name.getDOMNode().value = data.name;
        this.refs.topicName.getDOMNode().value = data.topic_name;
        this.refs.dataType.getDOMNode().value = data.data_type;
        this.refs.displayType.getDOMNode().value = data.display_type;
        this.refs.unit.getDOMNode().value = data.unit;
        this.refs.unitSymbol.getDOMNode().value = data.unit_symbol;
        this.setState({dataType: data.data_type});

        $(this.refs.spinner.getDOMNode()).hide();
        this.refs.btnSave.getDOMNode().disabled = false;

        if (res.method !== 'GET') {
          this.transitionTo('app', null, { _: 'ds', id: data.template_id });
        }
      }
    },
    getInitialState: function() {
      return {
        dataType: 'number'
      };
    },
    componentDidMount: function() {
      var dataStreamId = this.getParams().dataStreamId,
        templateId = this.getParams().templateId;

      $(this.refs.spinner.getDOMNode()).hide();
      if (dataStreamId) {
        DataStreamModelActions.load(templateId, dataStreamId);
      }
    },
    render: function() {
      var options = [<option value="line">Lines</option>,<option value="bar">Bars</option>];
      if (this.state.dataType === 'location') {
        options = <option value="map">Map</option>;
      } else if (this.state.dataType === 'base64image') {
        options = <option value="picture">Image View</option>;
      }

      var query = {_:'ds', id: this.getParams().templateId };
      return (
        <div className="row">
          <div className="col-md-8 col-md-offset-2">
            <div className="panel panel-dark">
              <div className="panel-heading"><b>Data Stream Information</b></div>
              <div className="panel-body">
                <div className="row">
                  <div className="col-md-6">
                    <div className="form-group">
                      <label>Name</label>
                      <input tabIndex="1" type="text" ref="name" className="form-control"
                        placeholder="e.g. intensity" autocomplete="off" />
                    </div>
                    <div className="form-group">
                      <label>Data Type</label>
                      <select tabIndex="3" ref="dataType" className="form-control" value={this.state.dataType} onChange={dataTypeChange.bind(this)}>
                        <option value="number">Number</option>
                        <option value="base64image">Base64 Image</option>
                        <option value="location">Location</option>
                      </select>
                    </div>
                    <div className="form-group">
                      <label>Unit</label>
                      <input tabIndex="5" type="text" ref="unit" className="form-control"
                        placeholder="e.g. Kilometers" autocomplete="off" />
                    </div>
                  </div>
                  <div className="col-md-6">
                    <div className="form-group">
                      <label>Topic Name</label>
                      <input tabIndex="2" type="text" ref="topicName" className="form-control"
                        autocomplete="off" />
                    </div>
                    <div className="form-group">
                      <label>Display Type</label>
                      <select tabIndex="4" ref="displayType" className="form-control">
                        {options}
                      </select>
                    </div>
                    <div className="form-group">
                      <label>Unit Symbol</label>
                      <input tabIndex="6" type="text" ref="unitSymbol" className="form-control"
                        placeholder="e.g. Km" autocomplete="off" />
                    </div>
                  </div>
                </div>
                <br />
                <button className="btn btn-light" ref="btnSave" onClick={save.bind(this)} >
                  <i className="fa fa-spinner fa-spin" ref="spinner"></i>
                  Save Changes
                </button>
                &nbsp;&nbsp;&nbsp;
                <Link to='app' query={query} title="Cancel">Cancel</Link><br/><br/>
              </div>
            </div>
          </div>
        </div>
      );
    }
  });
  window.DataStreamCreateView = DataStreamCreateView;
}).call(document);
