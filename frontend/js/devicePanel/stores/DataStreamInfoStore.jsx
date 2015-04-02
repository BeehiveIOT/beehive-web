(function() {
  window.DataStreamInfoStore = Reflux.createStore({
    init: function() {
      this.listenToMany(DataStreamActions);
      this.dataStreams = [];
    },
    onLoad: function(deviceId) {
      var url = '/devices/' + deviceId + '/datastreams';
      $http.get(url).then(function(res) {
        this.dataStreams = res;
        this.trigger(this.dataStreams);
      }.bind(this), function(err){});
    }
  });
}).call(document);
