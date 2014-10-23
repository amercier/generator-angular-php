# AngularJS generator with PHP

[![NPM version](https://badge.fury.io/js/generator-angular-php.svg)](http://badge.fury.io/js/generator-angular-php)
[![Build Status](https://travis-ci.org/amercier/generator-angular-php.svg)](https://travis-ci.org/amercier/generator-angular-php)
[![Code Climate](https://codeclimate.com/github/amercier/generator-angular-php/badges/gpa.svg)](https://codeclimate.com/github/amercier/generator-angular-php)
[![Dependency Status](https://david-dm.org/amercier/generator-angular-php.svg)](https://david-dm.org/amercier/generator-angular-php)
[![devDependency Status](https://david-dm.org/amercier/generator-angular-php/dev-status.svg)](https://david-dm.org/amercier/generator-angular-php#info=devDependencies)


Based on [generator-angular](https://github.com/yeoman/generator-angular). Adds
a `/app/api` folder containing a sample RESTful PHP API. The API is available under
`/api` URL. `During development, the PHP API is served by
[PHP built-in web server](http://php.net/manual/en/features.commandline.webserver.php)
and integrated seamlessly into the existing [connect](https://github.com/gruntjs/grunt-contrib-connect)
configuration. Integration is done with [grunt-connect-proxy](https://github.com/drewzboto/grunt-connect-proxy)
and [grunt-php](https://github.com/sindresorhus/grunt-php).

[Roadmap for upcoming plans/features/fixes](https://github.com/yeoman/generator-angular/issues/553)

## Usage

Install `generator-angular-php`:
```
npm install -g generator-angular-php
```

Make a new directory, and `cd` into it:
```
mkdir my-new-project && cd $_
```

Run `yo angular-php`, optionally passing an app name:
```
yo angular-php [app-name]
```

Run `grunt` for building and `grunt serve` for preview

In `app/api` directory, run `make install` to update Composer dependencies.


## Generators

Available generators:

* [angular-php](#app) (aka [angular-php:app](#app))
* [angular-php:controller](#controller)
* [angular-php:directive](#directive)
* [angular-php:filter](#filter)
* [angular-php:route](#route)
* [angular-php:service](#service)
* [angular-php:provider](#service)
* [angular-php:factory](#service)
* [angular-php:value](#service)
* [angular-php:constant](#service)
* [angular-php:decorator](#decorator)
* [angular-php:view](#view)

**Note: Generators are to be run from the root directory of your app.**

### App
Sets up a new AngularJS app, generating all the boilerplate you need to get started. The app generator also optionally installs Bootstrap and additional AngularJS modules, such as angular-resource (installed by default).

Example:
```bash
yo angular-php
```

### Route
Generates a controller and view, and configures a route in `app/scripts/app.js` connecting them.

Example:
```bash
yo angular-php:route myroute
```

Produces `app/scripts/controllers/myroute.js`:
```javascript
angular.module('myMod').controller('MyrouteCtrl', function ($scope) {
  // ...
});
```

Produces `app/views/myroute.html`:
```html
<p>This is the myroute view</p>
```

**Explicitly provide route URI**

Example:
```bash
yo angular-php:route myRoute --uri=my/route
```

Produces controller and view as above and adds a route to `app/scripts/app.js`
with URI `my/route`

### Controller
Generates a controller in `app/scripts/controllers`.

Example:
```bash
yo angular-php:controller user
```

Produces `app/scripts/controllers/user.js`:
```javascript
angular.module('myMod').controller('UserCtrl', function ($scope) {
  // ...
});
```
### Directive
Generates a directive in `app/scripts/directives`.

Example:
```bash
yo angular-php:directive myDirective
```

Produces `app/scripts/directives/myDirective.js`:
```javascript
angular.module('myMod').directive('myDirective', function () {
  return {
    template: '<div></div>',
    restrict: 'E',
    link: function postLink(scope, element, attrs) {
      element.text('this is the myDirective directive');
    }
  };
});
```

### Filter
Generates a filter in `app/scripts/filters`.

Example:
```bash
yo angular-php:filter myFilter
```

Produces `app/scripts/filters/myFilter.js`:
```javascript
angular.module('myMod').filter('myFilter', function () {
  return function (input) {
    return 'myFilter filter:' + input;
  };
});
```

### View
Generates an HTML view file in `app/views`.

Example:
```bash
yo angular-php:view user
```

Produces `app/views/user.html`:
```html
<p>This is the user view</p>
```

### Service
Generates an AngularJS service.

Example:
```bash
yo angular-php:service myService
```

Produces `app/scripts/services/myService.js`:
```javascript
angular.module('myMod').service('myService', function () {
  // ...
});
```

You can also do `yo angular-php:factory`, `yo angular-php:provider`, `yo angular-php:value`, and `yo angular-php:constant` for other types of services.

### Decorator
Generates an AngularJS service decorator.

Example:
```bash
yo angular-php:decorator serviceName
```

Produces `app/scripts/decorators/serviceNameDecorator.js`:
```javascript
angular.module('myMod').config(function ($provide) {
    $provide.decorator('serviceName', function ($delegate) {
      // ...
      return $delegate;
    });
  });
```

## Options
In general, these options can be applied to any generator, though they only affect generators that produce scripts.

### CoffeeScript
For generators that output scripts, the `--coffee` option will output CoffeeScript instead of JavaScript.

For example:
```bash
yo angular-php:controller user --coffee
```

Produces `app/scripts/controller/user.coffee`:
```coffeescript
angular.module('myMod')
  .controller 'UserCtrl', ($scope) ->
```

A project can mix CoffeScript and JavaScript files.

To output JavaScript files, even if CoffeeScript files exist (the default is to output CoffeeScript files if the generator finds any in the project), use `--coffee=false`.

### Minification Safe

**Removed**

[Related Issue #452](https://github.com/yeoman/generator-angular/issues/452): This option has been removed from the generator. Initially it was needed as ngMin was not entirely stable. As it has matured, the need to keep separate versions of the script templates has led to extra complexity and maintenance of the generator. By removing these extra burdens, new features and bug fixes should be easier to implement. If you are dependent on this option, please take a look at ngMin and seriously consider implementing it in your own code. It will help reduce the amount of typing you have to do (and look through) as well as make your code cleaner to look at.

By default, generators produce unannotated code. Without annotations, AngularJS's DI system will break when minified. Typically, these annotations that make minification safe are added automatically at build-time, after application files are concatenated, but before they are minified. The annotations are important because minified code will rename variables, making it impossible for AngularJS to infer module names based solely on function parameters.

The recommended build process uses `ngmin`, a tool that automatically adds these annotations. However, if you'd rather not use `ngmin`, you have to add these annotations manually yourself. **One thing to note is that `ngmin` does not produce minsafe code for things that are not main level elements like controller, services, providers, etc.:

```javascript
resolve: {
  User: function(myService) {
    return MyService();
  }
}
```

will need to be manually done like so:
```javascript
resolve: {
  User: ['myService', function(myService) {
    return MyService();
  }]
}
```


### Add to Index
By default, new scripts are added to the index.html file. However, this may not always be suitable. Some use cases:

* Manually added to the file
* Auto-added by a 3rd party plugin
* Using this generator as a subgenerator

To skip adding them to the index, pass in the skip-add argument:
```bash
yo angular-php:service serviceName --skip-add
```

## Bower Components

The following packages are always installed by the [app](#app) generator:

* angular
* angular-mocks
* angular-scenario


The following additional modules are available as components on bower, and installable via `bower install`:

* angular-cookies
* angular-loader
* angular-resource
* angular-sanitize

All of these can be updated with `bower update` as new versions of AngularJS are released.

## Configuration
Yeoman generated projects can be further tweaked according to your needs by modifying project files appropriately.

### Output
You can change the `app` directory by adding a `appPath` property to `bower.json`. For instance, if you wanted to easily integrate with Express.js, you could add the following:

```json
{
  "name": "yo-test",
  "version": "0.0.0",
  ...
  "appPath": "public"
}

```
This will cause Yeoman-generated client-side files to be placed in `public`.

## Testing

Running `grunt test` will run the unit tests with karma.

## Contribute

See the [contributing docs](https://github.com/yeoman/yeoman/blob/master/contributing.md)

When submitting an issue, please follow the [guidelines](https://github.com/yeoman/yeoman/blob/master/contributing.md#issue-submission). Especially important is to make sure Yeoman is up-to-date, and providing the command or commands that cause the issue.

When submitting a PR, make sure that the commit messages match the [AngularJS conventions](https://docs.google.com/document/d/1QrDFcIiPjSLDn3EL15IJygNPiHORgU1_OOAqWjiDU5Y/).

When submitting a bugfix, write a test that exposes the bug and fails before applying your fix. Submit the test alongside the fix.

When submitting a new feature, add tests that cover the feature.

## Changelog

Recent changes can be viewed on Github on the [Releases Page](https://github.com/yeoman/generator-angular/releases)

## License

[BSD license](http://opensource.org/licenses/bsd-license.php)
