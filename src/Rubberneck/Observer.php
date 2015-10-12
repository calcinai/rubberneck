<?php

/**
 * @package    rubberneck
 * @author     Michael Calcinai <michael@calcin.ai>
 */

namespace Calcinai\Rubberneck;

use Evenement\EventEmitterTrait;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;

use Calcinai\Rubberneck\Driver;

class Observer {

    use EventEmitterTrait;

    /**
     * @var \React\EventLoop\LibEvLoop|LoopInterface
     */
    private $loop;

    private $driver;

    /**
     * List of available drivers in order of preference
     *
     * @var Driver\DriverInterface[]
     */
    static $drivers = [
        Driver\FileStat::class
    ];

    /**
     * Observer constructor
     * @param LoopInterface $loop
     */
    public function __construct(LoopInterface $loop = null) {

        if($loop === null){
            $loop = Factory::create();
        }

        $this->loop = $loop;

        $driver_class = self::getBestDriver();
        $this->driver = new $driver_class($this);
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

}