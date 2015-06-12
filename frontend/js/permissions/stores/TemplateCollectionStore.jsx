(function(){
  var TemplateCollectionStore = Reflux.createStore({
    init: function() {
      this.listenToMany(TemplateActions);
      this.templates = [];
    },
    onLoad: function() {
      $http.get('/templates').then(function(res) {
        res.push({id:'-1', name: '---- Shared Devices ----'});
        this.templates = res;

        this.trigger(this.templates)
      }.bind(this), function(err) {})
    }
  });
  window.TemplateCollectionStore = TemplateCollectionStore;
}).call(document);
