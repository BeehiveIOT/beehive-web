(function() {
  var Link = ReactRouter.Link;
  var State = ReactRouter.State;

  function expandTemplate() {
    var query = this.getQuery();
    if (!query._ || !query.id) { return; }

    var el = $(this.refs['template_'+query.id].getDOMNode());
    if (query._ === 'c') {
      this.refs['template_'+query.id].expandCommands();
      $('body').animate({ scrollTop: el.offset().top - 100, scrollLeft: 0 });
    } else if (query._ === 'ds') {
      this.refs['template_'+query.id].expandDataStreams();
      $('body').animate({ scrollTop: el.offset().top - 100, scrollLeft: 0 });
    }
  }

  var ListView = React.createClass({
    mixins: [
      State,
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
        expandTemplate.call(this);
      } else if (action === 'templateUpdated'){
        this.onUpdate(data);
      }
    },
    render: function() {
      var templates = this.state.templates.map(function(item) {
        var refId = 'template_' + item.id
        return (
          <li>
            <Template ref={refId} template={item} onUpdate={this.onUpdate} />
          </li>
        );
      });
      return (
        <div className="row">
          <div className="col-md-8 col-md-offset-2">
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
