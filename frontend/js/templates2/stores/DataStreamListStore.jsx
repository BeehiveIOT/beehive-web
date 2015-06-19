(function() {

  window.DataStreamListStore = Reflux.createStore({
    init: function() {
      this.listenToMany(DataStreamListActions);
      this.dataStreams = [];
    },
    onLoad: function(templateId) {
      var url = '/templates/' + templateId + '/datastreams';
      $http.get(url).then(function(res) {
        this.dataStreams = res;
        this.trigger(this.dataStreams);
      }.bind(this), function(err) {});
    },
    onRemove: function(templateId, dataStreamId, index) {
      var url = '/templates/' + templateId + '/datastreams/' + dataStreamId;
      $http.remove(url, {}).then(function(res) {
        this.dataStreams.splice(index, 1);
        this.trigger(this.dataStreams);
      }.bind(this), function(err) {})
    }
  });
}).call();
