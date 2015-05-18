(function() {
  var DeviceCollectionStore = Reflux.createStore({
    init: function() {
      this.devices = [];
      this.listenToMany(DeviceActions);
    },
    onLoadByTemplate: function(templateId) {
      $http.get('/templates/' + templateId + '/devices').then(function(res) {
        this.devices = res;
        this.trigger(this.devices);
      }.bind(this), function(err) {})
    }
  });
  window.DeviceCollectionStore = DeviceCollectionStore;
}).call(document);
