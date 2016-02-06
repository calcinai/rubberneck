<?php
/**
 * @package    calcinai/rubberneck
 * @author     Michael Calcinai <michael@calcin.ai>
 */

namespace Calcinai\Rubberneck\Driver;

use Calcinai\Rubberneck\Observer;

abstract class AbstractDriver implements DriverInterface {

    /**
     * @var Observer $observer
     */
    protected $observer;

    public function __construct(Observer $observer) {
        $this->observer = $observer;
    }
}