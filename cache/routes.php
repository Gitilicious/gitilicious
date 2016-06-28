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
        0 => 'Gitilicious\\Presentation\\Controller\\Index',
        1 => 'index',
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