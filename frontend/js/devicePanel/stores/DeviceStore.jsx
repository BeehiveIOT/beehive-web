(function() {
  window.DeviceStore = Reflux.createStore({
    init: function() {
      this.listenToMany(DeviceActions);
      this.device = {};
    },
    onLoad: function(deviceId) {
      console.log('loading device from store');
      $http.get('/devices/'+deviceId).then(function(res){
        this.device = res;
        this.trigger('loaded', this.device);
      }.bind(this), function(err){});
    },
    onUpdate: function(deviceId, device) {
      console.log('updating device from store');
      $http.put('/devices/'+deviceId, device).then(function(res){
        this.device = res;
        this.trigger('updated', this.device);
      }.bind(this), function(err) {}.bind(this));
    }
  });
}).call(document);
