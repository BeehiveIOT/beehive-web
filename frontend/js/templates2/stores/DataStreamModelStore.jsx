(function() {

  window.DataStreamModelStore = Reflux.createStore({
    init: function() {
      this.listenToMany(DataStreamModelActions);
      this.dataStream = {};
    },
    onLoad: function(templateId, dataStreamId) {
      var url = '/templates/' + templateId + '/datastreams/' + dataStreamId;
      $http.get(url).then(function(res) {
        this.dataStream = res;
        this.trigger(this.dataStream, { code: 200 });
      }.bind(this), function(err) {});
    },
    onCreate: function(templateId, data) {
      var url = '/templates/' + templateId + '/datastreams';
      $http.post(url, data).then(function(res) {
        this.dataStream = res;
        this.trigger(this.dataStream, { code: 200 });
      }.bind(this), function(err) {})
    },
    onUpdate: function(templateId, dataStreamId, data) {
      var url = '/templates/' + templateId + '/datastreams/' + dataStreamId;
      $http.put(url, data).then(function(res) {
        this.dataStream = res;
        this.trigger(this.dataStream, { code: 200 });
      }.bind(this), function(err) {});
    }
  });
}).call();
