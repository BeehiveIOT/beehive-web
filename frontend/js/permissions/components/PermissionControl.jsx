(function() {

  function onUsernameChange(e) {
    var btnAdd = this.refs.btnAdd.getDOMNode();
    btnAdd.disabled = true;
    if (e.currentTarget.value.trim() !== '')  {
      btnAdd.removeAttribute('disabled');
    }
  }

  function resetControls() {
    this.refs.username.getDOMNode().value = '';
    this.refs.canEdit.getDOMNode().checked = false;
    this.refs.canExecute.getDOMNode().checked = false;
    this.refs.btnAdd.getDOMNode().disabled = true;
  }

  function addPermission(e) {
    if (!this.props.onPermissionAdded) {
      return;
    }
    var username = this.refs.username.getDOMNode().value,
      canEdit = this.refs.canEdit.getDOMNode().checked,
      canExecute = this.refs.canExecute.getDOMNode().checked;

    var data = {
      username: username, can_edit: canEdit, can_execute: canExecute
    };
    resetControls.call(this);
    this.props.onPermissionAdded(data);
  }

  var PermissionControl = React.createClass({
    componentDidMount: function() {
      this.refs.btnAdd.getDOMNode().disabled = true;
    },
    render: function() {
      return (
        <div className="row">
          <div className="col-md-4">
            <label>
              Username
              <input ref="username" className="form-control" onChange={onUsernameChange.bind(this)} />
            </label>
          </div>
          <div className="col-md-2">
            <label>
              <br />
              Edit&nbsp;&nbsp;
              <input ref="canEdit" type="checkbox" />
            </label>
          </div>
          <div className="col-md-2">
            <label>
              <br />
              Execute&nbsp;&nbsp;
              <input ref="canExecute" type="checkbox" />
            </label>
          </div>
          <div className="col-md-2">
            <br />
            <button ref="btnAdd" className="btn btn-light" onClick={addPermission.bind(this)}>
              <i className="fa fa-plus"></i>
            </button>
          </div>
        </div>
      );
    }
  });
  window.PermissionControl = PermissionControl;
}).call(document);
