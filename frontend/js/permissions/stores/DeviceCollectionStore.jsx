(function() {
  var DeviceCollectionStore = Reflux.createStore({
    init: function() {
      this.devices = [];
      this.listenToMany(DeviceActions);
    },
    onLoadByTemplate: function(templateId) {
      var url = '/templates/' + templateId + '/devices';
      if (templateId === '-1') {
        url = '/devices/shared';
      }

      $http.get(url).then(function(res) {
        this.devices = res;
        this.trigger(this.devices);
      }.bind(this), function(err) {})
    }
  });
  window.DeviceCollectionStore = DeviceCollectionStore;
}).call(document);
