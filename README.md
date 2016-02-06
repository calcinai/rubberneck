# Rubberneck
A simple binding for ReactPHP event loops to watch files.

Currently only file poling in implemented, but is designed with stubs for inotify or any other method.

The filesystem driver isn't the most efficient, but it works!

#Usage

```php
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


$observer->watch('~/Desktop/*.txt');

$loop->run();
```