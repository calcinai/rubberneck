<?php
/**
 * @package    rubberneck
 * @author     Michael Calcinai <michael@calcin.ai>
 */

namespace Calcinai\Rubberneck\Driver;


use Calcinai\Rubberneck\Observer;

class FileStat implements DriverInterface {

    public function __construct(Observer $observer) {
        // TODO: Implement __construct() method.
    }

    public static function hasDependencies() {
        //Assuming it's running on *nix
        return true;
    }

}