'use strict';

describe('Controller: <%= classedName %>Ctrl', function () {

  // load the controller's module
  beforeEach(module('<%= scriptAppName %>'));

  var <%= classedName %>Ctrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    $controller('<%= classedName %>Ctrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', inject(function ($httpBackend) {

    $httpBackend.whenGET('/api/features').respond([
      {
        id: 'html5-boilerplate',
        name: 'HTML5 Boilerplate',
        href: '/api/features/html5-boilerplate'
      },
      {
        id: 'angular',
        name: 'Angular',
        href: '/api/features/angular'
      },
      {
        id: 'karma',
        name: 'Karma',
        href: '/api/features/karma'
      }
    ]);

    var resources = {
      'html5-boilerplate': {
        name: 'HTML5 Boilerplate',
        description: 'HTML5 Boilerplate is a professional front-end template' +
          ' for building fast, robust, and adaptable web apps or sites.'
      },
      angular: {
        name: 'Angular',
        description: 'AngularJS is a toolset for building the framework most' +
          ' suited to your application development.'
      },
      karma: {
        name: 'Karma',
        description: 'Spectacular Test Runner for JavaScript.'
      }
    };
    $httpBackend.whenGET('/api/features/html5-boilerplate').respond(resources['html5-boilerplate']);
    $httpBackend.whenGET('/api/features/angular').respond(resources.angular);
    $httpBackend.whenGET('/api/features/karma').respond(resources.karma);

    $httpBackend.flush();

    expect(scope.awesomeThings.length).toBe(3);
  }));
});
