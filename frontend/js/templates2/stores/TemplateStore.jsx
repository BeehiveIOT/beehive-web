(function() {
  var actions = {
    TEMPLATES_LOADED: 'templatesLoaded',
    TEMPLATE_CREATED: 'templateCreated',
    TEMPLATE_UPDATED: 'templateUpdated'
  };

  window.TemplateStore = Reflux.createStore({
    init: function() {
      this.listenToMany(TemplateActions);
    },
    onLoadTemplates: function() {
      console.log('loading templates');
      $http.get('/templates').then(function(res) {
        this.trigger(actions.TEMPLATES_LOADED, res);
      }.bind(this), function(err) {});
    },
    onCreate: function(data) {
      $http.post('/templates', data).then(function(res) {
        this.trigger(actions.TEMPLATE_CREATED, res);
      }.bind(this), function(err){});
    },
    onUpdate: function(id, data) {
      $http.put('/templates/'+id, data).then(function(res) {
        this.trigger(actions.TEMPLATE_UPDATED, res);
      }.bind(this), function(err) {});
    }
  });
}).call();
