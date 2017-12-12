<?php

// Doctrine (db)
$app['db.options'] = array(
   'driver'   => 'oci8', 
    'service'   => 'true',
    'charset'  => 'AL32UTF8',
    'host'     => '10.0.2.2',
    'port'     => '1522',
    'dbname'   => 'pdb1',
    'user'     => 'pmuser',
    'password' => 'oracle'
);
