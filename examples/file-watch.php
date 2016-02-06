<?php

include __DIR__.'/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();
$observer = new \Calcinai\Rubberneck\Observer($loop);

$observer->onModify(function($file_name){
    echo "Modified: $file_name\n";
});

$observer->onCreate(function($file_name){
    echo "Created: $file_name\n";
});

$observer->onDelete(function($file_name){
    echo "Deleted: $file_name\n";
});


$observer->watch('/Users/Michael/Desktop/*.sql');

$loop->run();