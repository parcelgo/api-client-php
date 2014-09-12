<?php
require_once __DIR__ . '/../vendor/autoload.php';

$post2goClient = new Post2GoClient\Manager('INSERT YOUR API KEY HERE');

$courier = 'usps';
$trackingNumber = 'EC208786464US';
$couriersResponse = $post2goClient->couriers()->detect($trackingNumber)->getCouriers();
// list detected couriers
foreach ($couriersResponse as $courier) {
    echo $courier->getCountryCode() . ' ' . $courier->getName() . "\n";;
};

$couriersResponse = $post2goClient->couriers()->get()->getCouriers();
//list of all supported couriers
foreach ($couriersResponse as $courier) {
    echo $courier->getCountryCode() . ' ' . $courier->getName() . "\n";;
};

//add tracking number to parcelgo for tracking
$track = $post2goClient->tracking()->create($courier, $trackingNumber);

//get tracking info
$trackInfo = $post2goClient->tracking()->get($courier, $trackingNumber);
echo $trackInfo->getLastCheck()->format('Y-m-d H:i:s') . "\n";;

foreach ($trackInfo->getCheckpoints() as $checkpoint) {
    echo $checkpoint->getCountryCode() . ' ' . $checkpoint->getLocation() . ' ' . $checkpoint->getTime() . ' '
        . $checkpoint->getStatus() . ' ' . $checkpoint->getMessage() . "\n";
};

//reactivate tracking number
$post2goClient->tracking()->reactivate($courier, $trackingNumber);

//get last checkpoint of tracking number
$checkpoint = $post2goClient->lastCheckpoint()->get($courier, $trackingNumber)->getCheckpoint();
echo $checkpoint->getCountryCode() . "\n";
echo $checkpoint->getTime() . "\n";
echo $checkpoint->getLocation() . "\n";
echo $checkpoint->getCourierSlug() . "\n";
echo $checkpoint->getMessage() . "\n";
echo $checkpoint->getStatus() . "\n";

