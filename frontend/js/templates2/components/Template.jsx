(function($) {
  function changeContentBody(e) {
    var contentType = e.currentTarget.dataset.content;
    if (contentType) {
      this.setState({ contentType: contentType });
    }
  }

  function getContentBody() {
    switch(this.state.contentType) {
      case 'edit':
        return <TemplateEdit template={this.props.template}
          onCancel={onCancel.bind(this)} />;
      case 'commands':
        return <TemplateCommands template={this.props.template}
          onCancel={onCancel.bind(this)} />
      case 'dataStreams':
        return <TemplateDataStreams template={this.props.template}
          onCancel={onCancel.bind(this)} />;
    }
    return '';
  }

  function onCancel() {
    this.setState({contentType: ''});
  }
  var Template = React.createClass({
    getInitialState: function() {
      return {
        contentType: ''
      };
    },
    render: function() {
      var contentBody = getContentBody.call(this);
      return (
        <div>
          <div className="template-heading">
            <img src="/uploads/avatars/device.png" alt="" />
            <span>{this.props.template.name}</span>
            <div className="tools">
              <a href="javascript:void(0)" title="Edit" data-content='edit'
                onClick={changeContentBody.bind(this)} >
                <i className="fa fa-pencil"></i>
              </a>
              &nbsp;&nbsp;
              <div className="dropdown"  style={{display:'inline-block'}}>
                <a href="javascript:void(0)" data-toggle="dropdown"
                  title="Commands"><i className="fa fa-cogs"></i></a>
                <ul className="dropdown-menu" role="menu" aria-labelledby="dLabel">
                  <li>
                    <a href="javascript:void(0)" onClick={changeContentBody.bind(this)} data-content='commands'>
                      Commands
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" onClick={changeContentBody.bind(this)} data-content='dataStreams'>
                      Data Streams
                    </a>
                  </li>
                </ul>
              </div>
              &nbsp;&nbsp;
              <a href="javascript:void(0)" title="Remove Template"
                ng-click="delete($index)"><i className="fa fa-trash-o"></i></a>
            </div>
          </div>
          {contentBody}
          <br />
        </div>
      );
    }
  });
  window.Template = Template;
}).call(document, jQuery);
