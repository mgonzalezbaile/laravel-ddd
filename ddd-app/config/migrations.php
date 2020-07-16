<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Entity Manager Migrations Configuration
    |--------------------------------------------------------------------------
    |
    | Each entity manager can have a custom migration configuration. Provide
    | the name of the entity manager as the key, then duplicate the settings.
    | This will allow generating custom migrations per EM instance and not have
    | collisions when executing them.
    |
    */
    'default' => [
        /*
        |--------------------------------------------------------------------------
        | Migration Repository Table
        |--------------------------------------------------------------------------
        |
        | This table keeps track of all the migrations that have already run for
        | your application. Using this information, we can determine which of
        | the migrations on disk haven't actually been run in the database.
        |
        */
        'table'     => 'migrations',
        /*
        |--------------------------------------------------------------------------
        | Migration Directory
        |--------------------------------------------------------------------------
        |
        | This directory is where all migrations will be stored for this entity
        | manager. Use different directories for each entity manager.
        |
        */
        'directory' => database_path('migrations'),
        /*
        |--------------------------------------------------------------------------
        | Migration Organize Directory
        |--------------------------------------------------------------------------
        |
        | Organize migrations file by directory.
        | Possible values: "year", "year_and_month" and false
        |
        | false:
        |    directory/
        | "year":
        |    directory/2020/
        | "year_and_month":
        |    directory/2020/01/
        |
         */
        'organize_migrations' => false,
        /*
        |--------------------------------------------------------------------------
        | Migration Namespace
        |--------------------------------------------------------------------------
        |
        | This namespace will be used on all migrations. To prevent collisions, add
        | the entity manager name (connection name).
        |
        */
        'namespace' => 'Database\\Migrations',
        /*
        |--------------------------------------------------------------------------
        | Migration Repository Table
        |--------------------------------------------------------------------------
        |
        | Tables which are filtered by Regular Expression. You optionally
        | exclude or limit to certain tables. The default will
        | filter all tables.
        |
        */
        'schema'    => [
            'filter' => '/^(?!password_resets|failed_jobs).*$/'
        ],
        /*
        |--------------------------------------------------------------------------
        | Migration Version Column Length
        |--------------------------------------------------------------------------
        |
        | The length for the version column in the migrations table.
        |
        */
        'version_column_length' => 14
    ],
];
