About this directory:
=====================

By default, this application is configured to load all configs in
`./config/autoload/{,*.}{global,local}.php`. Doing this provides a
location for a developer to drop in configuration override files provided by
modules, as well as cleanly provide individual, application-wide config files
for things like database connections, etc.

  - ./config/autoload/{,*}.global.php files are included to the Git repository.
  - ./config/autoload/{,*}.local.php files are excluded from the Git repository
    as they contain all sensitive information (password, etc). It is recommended
    to include to your Git repository an example of the same file, with the
    .dist extension.

Example
-------

  - application.global.php    contains all non-sensitive, application-wide settings
  - database.global.php       contains all non-sensitive database settings
  - database.local.php        contains all sensitive database settings (excluded from Git)
  - database.local.php.dist   a skeleton of database.local.php with all sensitive information
                              replaced by * characters.
