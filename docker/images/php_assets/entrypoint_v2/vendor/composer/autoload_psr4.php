<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Util\\Command\\' => array($baseDir . '/cmd'),
    'Util\\' => array($baseDir . '/src'),
    'Psr\\Cache\\' => array($vendorDir . '/psr/cache/src'),
    'PackageVersions\\' => array($vendorDir . '/composer/package-versions-deprecated/src/PackageVersions'),
    'Doctrine\\Persistence\\' => array($vendorDir . '/doctrine/persistence/lib/Doctrine/Persistence'),
    'Doctrine\\Deprecations\\' => array($vendorDir . '/doctrine/deprecations/lib/Doctrine/Deprecations'),
    'Doctrine\\DBAL\\' => array($vendorDir . '/doctrine/dbal/src'),
    'Doctrine\\Common\\Lexer\\' => array($vendorDir . '/doctrine/lexer/lib/Doctrine/Common/Lexer'),
    'Doctrine\\Common\\Collections\\' => array($vendorDir . '/doctrine/collections/lib/Doctrine/Common/Collections'),
    'Doctrine\\Common\\Cache\\' => array($vendorDir . '/doctrine/cache/lib/Doctrine/Common/Cache'),
    'Doctrine\\Common\\Annotations\\' => array($vendorDir . '/doctrine/annotations/lib/Doctrine/Common/Annotations'),
    'Doctrine\\Common\\' => array($vendorDir . '/doctrine/common/lib/Doctrine/Common', $vendorDir . '/doctrine/event-manager/lib/Doctrine/Common', $vendorDir . '/doctrine/persistence/lib/Doctrine/Common'),
);
