<?php declare(strict_types=1);

$texts = [
    'site.title'                                            => 'ProjectX',

    'nav.dashboard'                                         => 'Dashboard',

    'preflight.database.connection.test'                    => 'Checking database connection',
    'preflight.database.connection.error.noconnection'      => 'Couldn\'t connect to database',
    'preflight.database.connection.error.unknown'           => 'Unknown error',
    'preflight.database.connection.success'                 => 'Connection established',
    'preflight.database.empty.test'                         => 'Checking whether the database is empty',
    'preflight.database.empty.success'                      => 'Database is uninitialized',
    'preflight.database.error.notempty'                     => 'Database already contains tables',
    'preflight.database.createtable.test'                   => 'Test table creation permissions',
    'preflight.database.createtable.success'                => 'Table created successfully',
    'preflight.database.createtable.nopermissions'          => 'Cannot create table',
    'preflight.database.droptable.test'                     => 'Test drop table permissions',
    'preflight.database.droptable.success'                  => 'Table dropped successfully',
    'preflight.database.droptable.nopermissions'            => 'Cannot drop table. Please confirm the permissions and manually remove rhe test table.',
    'preflight.database.repodir.test'                       => 'Test repository directory permissions',
    'preflight.database.repodir.success.directoryexists'    => 'Directory exists',
    'preflight.database.repodir.success.directorycreated'   => 'Directory created',
    'preflight.database.repodir.cannotcreatedirectory'      => 'Cannot create directory',
    'preflight.database.repodir.directorynotempty'          => 'Directory not empty',
    'preflight.database.repodir.nowritepermissions'         => 'No write permissions in directory',
    'preflight.database.repodir.success.directorywritable'  => 'Directory writable',
    'preflight.database.repodir.noremovepermissions'        => 'No delete permissions',
    'preflight.database.repodir.success.directorydeleted'   => 'Directory has delete permissions',
    'preflight.database.sendmail.test'                      => 'Testing sendmail',
];
