(function() {

  BeehiveBridge = function(opts) {
    this.wsUrl = opts.wsUrl;
    this.deviceKey = opts.deviceKey;

    this.options = opts;
    this.callbacks = {
      connect: null,
      error: null,
      close: null
    };

    this.userCallbacks = {};
  };

  BeehiveBridge.prototype = {
    connect: function(){
      this.socket = new SockJS(this.wsUrl);

      this.socket.onopen = onSocketOpen.bind(this);
      this.socket.onmessage = onSocketMessage.bind(this);
      this.socket.onclose = onSocketClose.bind(this);
    },
    on: function(event, callback) {
      if (this.callbacks.hasOwnProperty(event)) {
        this.callbacks[event] = callback;
      }
    },
    subscribe: function(topic, callback) {
      this.userCallbacks[topic] = callback;
      this.socket.send(JSON.stringify({
        event: 'subscribe',
        data: {
          topic: topic
        }
      }));
    },
  };

  onSocketOpen = function() {
    // Socket opened, now it needs to be authenticated
    this.socket.send(JSON.stringify({
      event: 'auth',
      data: {
        username: this.options.deviceKey,
        password: this.options.deviceKey,
      }
    }));
  };

  onSocketMessage = function(message) {
    try {
      var data = JSON.parse(message.data);

      if (this.callbacks[data.event] && !data.isTopic) {
        this.callbacks[data.event].call(this);
      } else if (this.userCallbacks[data.event] && data.isTopic) {
        var dataToSend = {
          topic: data.event,
          data: data.data
        };
        this.userCallbacks[data.event].call(this, dataToSend);
      }
    } catch (err) {
      console.log('ERROR', err);
    }
  };

  onSocketClose = function() {
    if (this.callbacks.close) {
      this.callbacks.close.call(this);
    }
  };
}).call(document);
