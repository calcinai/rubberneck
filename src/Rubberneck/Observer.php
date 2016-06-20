<?php

/**
 * @package    rubberneck
 * @author     Michael Calcinai <michael@calcin.ai>
 */

namespace Calcinai\Rubberneck;

use Evenement\EventEmitterTrait;
use React\EventLoop\LoopInterface;

use Calcinai\Rubberneck\Driver;

class Observer {

    use EventEmitterTrait;

    const EVENT_CREATE = 'create';
    const EVENT_MODIFY = 'modify';
    const EVENT_DELETE = 'delete';

    /**
     * @var \React\EventLoop\LibEvLoop|LoopInterface
     */
    private $loop;

    /**
     * @var Driver\DriverInterface
     */
    private $driver;

    protected $listeners;

    /**
     * List of available drivers in order of preference
     *
     * @var Driver\DriverInterface[]
     */
    static $drivers = [
        Driver\InotifyWait::class,
        Driver\Filesystem::class
    ];

    /**
     * Observer constructor
     * @param LoopInterface $loop
     */
    public function __construct(LoopInterface $loop) {

        $this->loop = $loop;

        $driver_class = self::getBestDriver();
        $this->driver = new $driver_class($this);
    }


    public function watch($path) {
        $this->driver->watch($path);
    }


    public function getSubscribedEvents(){
        return array_keys($this->listeners);
    }


    public function getLoop() {
        return $this->loop;
    }


    public static function getBestDriver(){

        foreach(self::$drivers as $driver){
            if($driver::hasDependencies()){
                return $driver;
            }
        }

        //Should never happen since the file poll can always work.
        throw new \Exception('No drivers available');
    }


    public function onCreate($callback) {
        $this->on(self::EVENT_CREATE, $callback);
    }

    public function onModify($callback) {
        $this->on(self::EVENT_MODIFY, $callback);
    }

    public function onDelete($callback) {
        $this->on(self::EVENT_DELETE, $callback);
    }

}