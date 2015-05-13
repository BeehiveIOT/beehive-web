(function() {
  var Link = ReactRouter.Link;
  var ListView = React.createClass({
    mixins: [
      Reflux.listenTo(window.TemplateStore, 'onTemplateChange'),
    ],
    getInitialState: function() {
      return {
        templates: []
      }
    },
    componentDidMount: function() {
      TemplateActions.loadTemplates();
    },
    onUpdate: function(data) {
      var templates = this.state.templates
      for(var i = 0; i < templates.length; ++i) {
        if (templates[i].id === data.id) {
          templates[i] = data;
          break;
        }
      }
      this.setState({templates: templates});
    },
    onTemplateChange: function(action, data) {
      if (action === 'templatesLoaded') {
        this.setState({templates: data});
      } else if (action === 'templateUpdated'){
        this.onUpdate(data);
      }
    },
    render: function() {
      var templates = this.state.templates.map(function(item) {
        return (
          <li>
            <Template template={item} onUpdate={this.onUpdate} />
          </li>
        );
      });
      return (
        <div className="row">
          <div className="col-md-6 col-md-offset-3">
            <div className="panel panel-dark">
              <div className="panel-heading"><b>Manage your templates</b></div>
              <div className="panel-body">
                <div className="row">
                  <div className="col-md-10">
                    <Link to="create" className="btn btn-light">
                      <i className="fa fa-plus"></i> Add new Template
                    </Link>
                  </div>
                </div>
                <ul className="template-list">
                  { templates }
                </ul>
              </div>
            </div>
          </div>
        </div>
      );
    }
  });
  window.ListView = ListView;
}).call(document);
