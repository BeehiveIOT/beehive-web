(function($) {
  var Navigation = ReactRouter.Navigation;
  var Link = ReactRouter.Link;

  function onCancel() {
    if (this.props.onCancel) {
      this.props.onCancel();
    }
  }

  function newDataStream() {
    this.transitionTo('createDataStream', {templateId: this.props.template.id});
  }

  function removeDataStream(e) {
    if (!confirm('Are you sure you want to delete this data stream?')) {
      return;
    }

    var dataStreamId = e.currentTarget.dataset.streamId,
      index = e.currentTarget.dataset.index,
      templateId = this.props.template.id;

    DataStreamListActions.remove(templateId, dataStreamId, index);
  }

  function getDataStreamRows() {
    var dataStreams = this.state.dataStreams;
    return dataStreams.map(function(item, idx) {
      var params = {templateId: this.props.template.id, dataStreamId: item.id};
      return (
        <tr>
          <td>{idx+1}</td>
          <td>{item.name}</td>
          <td>{item.data_type}</td>
          <td>{item.display_type}</td>
          <td>
            <Link to="editDataStream" className="btn btn-light" params={params}>
              <i className="fa fa-pencil"></i>
            </Link>
          </td>
          <td>
            <a href="javascript:void(0)" className="btn btn-light"
              data-stream-id={item.id} data-index={idx}
              onClick={removeDataStream.bind(this)}>
              <i className="fa fa-trash-o"></i>
            </a>
          </td>
        </tr>
      );
    }.bind(this));
  }

  var TemplateDataStreams = React.createClass({
    mixins: [
      Navigation,
      Reflux.listenTo(DataStreamListStore, 'onCommandChange')
    ],
    onCommandChange: function(dataStreams) {
      this.setState({dataStreams: dataStreams});
      $(this.refs.spinner.getDOMNode()).hide();
    },
    getInitialState: function() {
      return {
        dataStreams: []
      };
    },
    componentDidMount: function() {
      DataStreamListActions.load(this.props.template.id);
    },
    render: function() {
      var dataStreamRows = getDataStreamRows.call(this);
      return (
        <div className="template-edit">
          <div className="row">
            <div className="col-md-12">
              <button type="button" className="close close-button" title="Close"
                onClick={onCancel.bind(this)}>&times;</button>
              <div className="row">
                <div className="col-md-4">
                  <h4>Data Streams <i className="fa fa-spinner fa-spin" ref="spinner"></i></h4>
                </div>
                <div className="col-md-4">
                  <button className="btn btn-light" onClick={newDataStream.bind(this)}>
                    <i className="fa fa-plus"></i> Add new Data Stream
                  </button>
                </div>
              </div>

              <table className="table">
                <thead>
                  <th className="col-md-2">#</th>
                  <th className="col-md-3">Name</th>
                  <th className="col-md-2">Data Type</th>
                  <th className="col-md-4">Display Type</th>
                  <th className="col-md-1">
                  </th>
                  <th className="col-md-1"></th>
                </thead>
                <tbody>
                {dataStreamRows}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      );
    }
  });
  window.TemplateDataStreams = TemplateDataStreams;
}).call(document, jQuery);
