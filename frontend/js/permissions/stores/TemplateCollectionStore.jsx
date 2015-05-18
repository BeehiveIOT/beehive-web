(function(){
  var TemplateCollectionStore = Reflux.createStore({
    init: function() {
      this.listenToMany(TemplateActions);
      this.templates = [];
    },
    onLoad: function() {
      $http.get('/templates').then(function(res) {
        this.templates = res;
        this.trigger(res)
      }.bind(this), function(err) {})
    }
  });
  window.TemplateCollectionStore = TemplateCollectionStore;
}).call(document);
