angular.module('beehive')
.controller('CommandEditCtrl',[
  '$scope',
  '$location',
  '$routeParams',
  'Template',
  function($scope, $location, $routeParams, Template) {
    $scope.working = false;
    var templateId = $routeParams.templateId;
    var commandId = $routeParams.commandId;

    $scope.typeSettings = {
      string: {
        placeholder: "e.g. lights_on",
        control: 'text'
      },
      int: {
        placeholder: "e.g. 42",
        control: 'number'
      },
      number: {
        placeholder: "",
        control: 'number'
      }
    };

    $scope.cmd_type = "string";
    $scope.arg_type = "string";
    $scope.arguments = [];

    if (commandId) {
      Template.getCommand(commandId, templateId)
      .then(function(res){
        $scope.id = res.data.id;
        $scope.name = res.data.name;
        $scope.short_cmd = res.data.short_cmd;
        $scope.cmd_type = res.data.cmd_type;
        $scope.template_id = res.data.template_id;
        $scope.arguments = res.data.arguments;
      }, function(err){});
    }

    $scope.addArgument = function() {
      if (!$scope.arg_name || !$scope.arg_type) {
        return;
      }
      if (((!$scope.arg_max || !$scope.arg_min) &&
          $scope.arg_type === 'number') || $scope.arg_min > $scope.arg_max) {
        return;
      }
      // console.log("min: ", $scope.arg_min, "max: ", $scope.arg_max);

      var argument = {
        name: $scope.arg_name,
        type: $scope.arg_type,
        default: $scope.arg_default || "",
        maximum: $scope.arg_max || null,
        minimum: $scope.arg_min || null
      };

      // Update rest resource if it exists, in other case,
      // just add to local array and wait for saveCommand
      if (commandId) {
        Template.createArgument(commandId, argument)
        .then(function(res){
          argument.id = res.data.id;
          argument.name = res.data.name;
          argument.type = res.data.type;

          $scope.arguments.push(argument);
        }, function(err){});
      } else {
        $scope.arguments.push(argument);
      }

      $scope.arg_name = ""; $scope.arg_type = "string";
      $scope.arg_min = ""; $scope.arg_max = ""; $scope.arg_default = "";
    };

    $scope.saveCommand = function() {
      if (!$scope.name || !$scope.short_cmd || !$scope.cmd_type) {
        return;
      }
      $scope.working = true;

      var command = {
        name: $scope.name,
        short_cmd: $scope.short_cmd,
        type: $scope.cmd_type,
        arguments: $scope.arguments
      };

      if (commandId) {
        Template.updateCommand(command, templateId).then(function(res){
          $scope.working = false;
          $location.url('/');
        }, function(err) {
          $scope.working = false;
        });
      } else {
        Template.createCommand(command, templateId).then(function(res) {
          $scope.working = false;
        }, function(err){
          $scope.working = false;
          $location.url('/');
        });
      }
    };

    $scope.removeArgument = function(index) {
      var argument = $scope.arguments[index];

      if (argument.id) {
        Template.deleteArgument(commandId, argument.id).then(function(res) {
          $scope.arguments.splice(index, 1);
        }, function(err){});
      } else {
        $scope.arguments.splice(index, 1);
      }
    };
  }
]);
