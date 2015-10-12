<?php

/**
 * @package    rubberneck
 * @author     Michael Calcinai <michael@calcin.ai>
 */

namespace Calcinai\Rubberneck\Driver;

use Calcinai\Rubberneck\Observer;

interface DriverInterface {
    public function __construct(Observer $observer);
    public static function hasDependencies();
}