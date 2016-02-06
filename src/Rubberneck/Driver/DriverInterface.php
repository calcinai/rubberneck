<?php

/**
 * @package    rubberneck
 * @author     Michael Calcinai <michael@calcin.ai>
 */

namespace Calcinai\Rubberneck\Driver;

use Calcinai\Rubberneck\Observer;

interface DriverInterface {
    public function watch($path);
    public static function hasDependencies();
}