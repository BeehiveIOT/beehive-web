(function() {
  var DevicePermissionStore = Reflux.createStore({
    init: function() {
      this.listenToMany(PermissionActions);
      this.permissions = [];
    },
    onLoadPermissionsByDevice: function(deviceId) {
      var url = '/devices/' + deviceId + '/permissions';
      $http.get(url).then(function(res) {
        this.permissions = res;
        this.trigger(this.permissions);
      }.bind(this), function(err) { });
    },
    onAddPermission: function(deviceId, data) {
      var url = '/devices/' + deviceId + '/permissions';

      $http.post(url, data).then(function(res) {

        PermissionActions.loadPermissionsByDevice(deviceId);
      }.bind(this), function(err) {
        alert(JSON.stringify(err));
      });
    },
    onRemovePermission: function(deviceId, userId) {
      var url = '/devices/' + deviceId + '/permissions/' + userId;
      $http.delete(url).then(function(res) {
        PermissionActions.loadPermissionsByDevice(deviceId);
      }.bind(this), function(err) { });
    }
  });
  window.DevicePermissionStore = DevicePermissionStore;
}).call(document);
