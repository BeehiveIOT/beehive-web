(function() {
  function subscriptionCallback(res) {
    this.trigger(res);
  }

  function onConnect() {
    console.log('BRIDGE CONNECTED');
    this.connected = true;
    var bridge = this.bridge;

    var subscriptions = this.subscriptions;
    for(var key in subscriptions) {
      if (!subscriptions[key].subscribed) {
        bridge.subscribe(key, subscriptionCallback.bind(this));
        subscriptions[key].subscribed = true;
      }
    }
  }

  window.DataStreamStore = Reflux.createStore({
    init: function() {
      this.initBridge();
      this.listenToMany(DataStreamActions);
      this.subscriptions = {};
      this.connected = false;
    },
    initBridge: function() {
      var bridge = new BeehiveBridge({
        wsUrl: 'http://' + document.domain +':9999/echo',
        deviceKey: 'sergio' // TODO change to something real :P
      });
      this.bridge = bridge;
      bridge.on('connect', onConnect.bind(this));
      bridge.connect();
    },
    onSubscribe: function(topic) {
      console.log('subscribed to', topic);
      this.subscriptions[topic] = {};
      if (this.connected) {
        this.bridge.subscribe(topic, subscriptionCallback.bind(this));
      } else {
        this.subscriptions[topic].subscribed = false;
      }
    }
  });
}).call(document);

/**


bridge.on('connect', function() {
  console.log('TEST CONNECTED');

  bridge.subscribe('car/location', function(res) {
    try {
      var data = JSON.parse(res.data);
      console.log(data);
      var position = new google.maps.LatLng(data.lat, data.lng);
      addElementToPath(position);
    } catch(e) {
      console.log("ERROR: ", res.data, e);
    }
  });
});

bridge.on('error', function(err) {
  console.log('TEST ERROR', err);
});

bridge.connect();
 *
 */
