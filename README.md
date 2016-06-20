# Rubberneck
A simple binding for ReactPHP event loops to watch files.

Currently only file poling and inotifywait in implemented, but is designed with stubs for other methods.

If possible, install `inotifywait` on your system, in Debian it's in the `inotify-tools` package.  It is much more efficient than the file 
poll method.

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