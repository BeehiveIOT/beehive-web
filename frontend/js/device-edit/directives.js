angular.module('directives', [])
.directive('myMessages', [function() {
  return function(scope, element, attr) {
    scope.$on('notify-message', function(event, message) {
      tpl = '';
      tpl += '<div class="alert alert-success alert-dismissable">';
      tpl += '<button type="button" class="close" data-dismiss="alert"';
      tpl += ' aria-hidden="true">&times;</button>';
      tpl += message;
      tpl += '</div>';
      element.append(tpl);
    });
    scope.$on('notify-error', function(event, message) {
      tpl = '';
      tpl += '<div class="alert alert-danger alert-dismissable">';
      tpl += '<button type="button" class="close" data-dismiss="alert"';
      tpl += ' aria-hidden="true">&times;</button>';
      tpl += message;
      tpl += '</div>';
      element.append(tpl);
    });
  };
}]);
