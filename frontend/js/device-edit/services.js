angular.module('services', [])
.factory('GlobalService', [function() {
  var url = document.URL;
  var pattern = /\/models\/(\d+)\/edit/;
  var match = url.match(pattern);
  var id = 0;
  if (match) {
    id = match[1];
  }
  return {
    deviceId: id
  };
}]);

