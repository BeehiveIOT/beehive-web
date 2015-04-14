(function() {
  var Link = ReactRouter.Link;
  var Navigation = ReactRouter.Navigation;

  var CreateView = React.createClass({
    mixins: [
      Navigation,
      Reflux.listenTo(window.TemplateStore, 'onTemplateChange'),
    ],
    getInitialState: function() {
      return {
        templates: []
      };
    },
    onTemplateChange: function(action, data) {
      if (action === 'templateCreated') {
        this.transitionTo('app');
      }
    },
    save: function() {
      var name = this.refs.name.getDOMNode().value;
      var description = this.refs.description.getDOMNode().value;

      TemplateActions.create({
        name: name,
        description: description
      });
    },
    render: function() {
      return (
        <div className="row">
          <div className="col-md-6 col-md-offset-3">
            <div className="panel panel-dark">
              <div className="panel-heading"><b>Template Information</b></div>
              <div className="panel-body">
                <div className="form-group">
                  <label>Name</label>
                  <input ref="name" className="form-control" placeholder="Template Name"
                    autocomplete="off" />
                </div>
                <div className="form-group">
                  <label>Description</label>
                  <textarea ref="description" className="form-control"></textarea>
                </div>
                <div className="form-group">
                  <button className="btn btn-light" onClick={this.save}>
                    Save Changes
                  </button>
                  &nbsp;&nbsp;
                  <Link to="app" title="Cancel">Cancel</Link>
                </div>
              </div>
            </div>
          </div>
        </div>

      );
    }
  });
  window.CreateView = CreateView;
}).call(document);
