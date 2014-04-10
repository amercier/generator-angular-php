'use strict';

describe('Controller: <%= classedName %>Ctrl', function () {

  // load the controller's module
  beforeEach(module('<%= scriptAppName %>'));

  var <%= classedName %>Ctrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    <%= classedName %>Ctrl = $controller('<%= classedName %>Ctrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', inject(function ($httpBackend) {

    $httpBackend.whenGET('/api/resource.php').respond({
      resources: [
        {
          id: 'html5-boilerplate',
          name: 'HTML5 Boilerplate',
          href: '/api/resource.php?id=html5-boilerplate'
        },
        {
          id: 'angular',
          name: 'Angular',
          href: '/api/resource.php?id=angular'
        },
        {
          id: 'karma',
          name: 'Karma',
          href: '/api/resource.php?id=karma'
        }
      ]
    });

    var resources = {
      'html5-boilerplate': {
        name: 'HTML5 Boilerplate',
        description: 'HTML5 Boilerplate is a professional front-end template' +
          ' for building fast, robust, and adaptable web apps or sites.'
      },
      angular-php: {
        name: 'Angular',
        description: 'AngularJS is a toolset for building the framework most' +
          ' suited to your application development.'
      },
      karma: {
        name: 'Karma',
        description: 'Spectacular Test Runner for JavaScript.'
      }
    };
    $httpBackend.whenGET('/api/resource.php?id=html5-boilerplate').respond(resources['html5-boilerplate']);
    $httpBackend.whenGET('/api/resource.php?id=angular').respond(resources.angular);
    $httpBackend.whenGET('/api/resource.php?id=karma').respond(resources.karma);

    $httpBackend.flush();

    expect(scope.awesomeThings.length).toBe(3);
  }));
});
