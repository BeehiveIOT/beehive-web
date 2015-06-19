(function($) {
  function geyQueryString(data) {
    if (!data) { return ''; }

    var queryString = '?', first = true;
    for(var key in data) {
      if (first) {
        first = false;
      } else {
        queryString += '&';
      }
      queryString += key + '=' + data[key];
    }
    return queryString;
  }

  function getHttpRequest(url, method, data) {
    data = JSON.stringify(data);
    return $.ajax(url, {
      contentType: 'application/json',
      data: data,
      dataType: 'json',
      type: method
    });
  }

  var $http = {
    get: function(url, data) {
      url = url + geyQueryString(data);
      return $.ajax(url);
    },
    post: function(url, data) {
      return getHttpRequest(url, 'POST', data);
    },
    put: function(url, data) {
      return getHttpRequest(url, 'PUT', data);
    },
    remove: function(url, data) {
      return getHttpRequest(url, 'DELETE', data);
    }
  };
  window.$http = $http;
}).call(document, jQuery);
