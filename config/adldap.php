<?php
/**
 * Created by PhpStorm.
 * User: abhay adm
 * Date: 5/6/2015
 * Time: 10:36 PM
 */
return array(
    'account_suffix' => "@zone24.com",

    'domain_controllers' => array("192.168.1.11"), // An array of domains may be provided for load balancing.

    'base_dn' => 'DC=zone24,DC=com',

    'admin_username' => 'abhayan',

    'admin_password' => 'Iagree123',
    'real_primary_group' => true, // Returns the primary group (an educated guess).

    'use_ssl' => false, // If TLS is true this MUST be false.

    'use_tls' => false, // If SSL is true this MUST be false.

    'recursive_groups' => true,
);

?>