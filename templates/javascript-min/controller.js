'use strict';

angular.module('<%= scriptAppName %>')
  .controller('<%= classedName %>Ctrl', ['$scope', function ($scope) {

    $scope.awesomeThings = [];
    $scope.loading = true;

    // Get awesome things list
    $http({method: 'GET', url: '/api/resource.php'}).

      success(function (data) {
        $scope.loading = false;
        $scope.awesomeThings = data.resources;

        // Get description of each thing
        $scope.awesomeThings.forEach(function (thing) {
          thing.loading = true;

          $http({method: 'GET', url: thing.href}).
            success(function (data) {
              thing.loading = false;
              thing.description = data.description;
            }).
            error(function (data) {
              thing.loading = false;
              thing.error = data.description || 'Server is unreachable';
            });
        });
      }).

      error(function (data) {
        $scope.loading = false;
        $scope.error = data.description || 'Server is unreachable';
      });

  }]);
