'use strict';

angular.module('<%= scriptAppName %>')
  .controller('<%= classedName %>Ctrl', function ($scope, $http) {

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
            error(function (data, status) {
              thing.loading = false;
              thing.error = data || {
                  status: status,
                  statusText: 'Internal Server Error',
                  description: 'No details available'
                };
            });
        });
      }).

      error(function (data, status) {
        $scope.loading = false;
        $scope.error = data || {
            status: status,
            statusText: 'Internal Server Error',
            description: 'No details available'
          };
      });

  });
