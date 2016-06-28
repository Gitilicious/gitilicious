<?php return array (
  0 => 
  array (
    'GET' => 
    array (
      '/not-found' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Error',
        1 => 'notFound',
      ),
      '/method-not-allowed' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Error',
        1 => 'methodNotAllowed',
      ),
      '/' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Installation',
        1 => 'render',
      ),
      '/preflight' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Preflight',
        1 => 'preflight',
      ),
      '/preflight/database-connection' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Preflight',
        1 => 'databaseConnection',
      ),
      '/preflight/empty-database' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Preflight',
        1 => 'emptyDatabase',
      ),
      '/preflight/create-table' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Preflight',
        1 => 'createTable',
      ),
      '/preflight/drop-table' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Preflight',
        1 => 'dropTable',
      ),
      '/preflight/repo-directory' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Preflight',
        1 => 'repoDirectory',
      ),
      '/preflight/sendmail' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Preflight',
        1 => 'sendmail',
      ),
    ),
    'POST' => 
    array (
      '/' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Installation',
        1 => 'handle',
      ),
      '/preflight/database-connection/test' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Preflight',
        1 => 'testDatabaseConnection',
      ),
      '/preflight/empty-database/test' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Preflight',
        1 => 'testEmptyDatabase',
      ),
      '/preflight/create-table/test' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Preflight',
        1 => 'testCreateTable',
      ),
      '/preflight/drop-table/test' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Preflight',
        1 => 'testDropTable',
      ),
      '/preflight/repo-directory/test' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Preflight',
        1 => 'testRepoDirectory',
      ),
      '/preflight/sendmail/test' => 
      array (
        0 => 'Gitilicious\\Presentation\\Controller\\Preflight',
        1 => 'testSendmail',
      ),
    ),
  ),
  1 => 
  array (
    'GET' => 
    array (
      0 => 
      array (
        'regex' => '~^(?|/js/(.+)|/css/(.+)()|/fonts/(.+)()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 
            array (
              0 => 'Gitilicious\\Presentation\\Controller\\Resource',
              1 => 'renderJavascript',
            ),
            1 => 
            array (
              'filename' => 'filename',
            ),
          ),
          3 => 
          array (
            0 => 
            array (
              0 => 'Gitilicious\\Presentation\\Controller\\Resource',
              1 => 'renderStylesheet',
            ),
            1 => 
            array (
              'filename' => 'filename',
            ),
          ),
          4 => 
          array (
            0 => 
            array (
              0 => 'Gitilicious\\Presentation\\Controller\\Resource',
              1 => 'renderFont',
            ),
            1 => 
            array (
              'filename' => 'filename',
            ),
          ),
        ),
      ),
    ),
  ),
);