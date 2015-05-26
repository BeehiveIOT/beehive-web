(function() {
  function hide() {
    if (this.props.onCancel) {
      this.props.onCancel();
    }
  }

  function save() {
    this.refs.btnSave.getDOMNode().disabled = true;
    $(this.refs.spinner.getDOMNode()).show();

    var templateId = this.refs.id.getDOMNode().value;
    TemplateActions.update(templateId, {
      name: this.refs.name.getDOMNode().value,
      description: this.refs.description.getDOMNode().value
    });
  }

  var TemplateEdit = React.createClass({
    mixins: [
      Reflux.listenTo(window.TemplateStore, 'onTemplateChange'),
    ],
    componentDidMount: function() {
      $(this.refs.spinner.getDOMNode()).hide();
    },
    onTemplateChange: function(action, data) {
      if (action === 'templateUpdated') {
        if (this.props.onCancel) {
          this.props.onCancel();
        }
      }
    },
    render: function() {
      return (
        <div className="template-edit">
          <div className="row">
            <div className="col-md-12">
              <div className="form-group">
                <label>Name</label>
                <input type="hidden" ref="id" value={this.props.template.id} />
                <input ref="name" className="form-control" placeholder="Template Name"
                    autocomplete="off" defaultValue={this.props.template.name} />
              </div>
              <div className="form-group">
                <label>Description</label>
                <textarea ref="description" className="form-control"
                  defaultValue={this.props.template.description}>
                </textarea>
              </div>
              <div className="form-group">
                <button className="btn btn-light" ref="btnSave" onClick={save.bind(this)} >
                  <i className="fa fa-spinner fa-spin" ref="spinner"></i>
                  Save Changes
                </button>
                &nbsp;&nbsp;&nbsp;
                <a href="javascript:void(0)" onClick={hide.bind(this)}>Cancel</a>
              </div>
            </div>
          </div>
        </div>

      );
    }
  });
  window.TemplateEdit = TemplateEdit;
}).call(document);
