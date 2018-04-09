<?php
/**
 * @package    calcinai/phpi
 * @author     Michael Calcinai <michael@calcin.ai>
 */

namespace Calcinai\Rubberneck\Driver;

use Calcinai\Rubberneck\Observer;

class InotifyWait extends AbstractDriver implements DriverInterface {

    const IN_CREATE = 'CREATE';
    const IN_MODIFY = 'MODIFY';
    const IN_DELETE = 'DELETE';



    static $IN_EVENT_MAP = [
        self::IN_CREATE => Observer::EVENT_CREATE,
        self::IN_MODIFY => Observer::EVENT_MODIFY,
        self::IN_DELETE => Observer::EVENT_DELETE
    ];

    public function watch($path) {

        $subprocess_cmd = sprintf('inotifywait -mr %s 2>/dev/null', $path);

        $this->observer->getLoop()->addReadStream(popen($subprocess_cmd, 'r'), [$this, 'onData']);

        return true;
    }


    /**
     * Public vis for callback, not cause it should be called by anyone.
     *
     * @param $stream
     */
    public function onData($stream){        
        $event_lines = fread($stream, 1024);

        //Can have multiple events per read (or not enough)
        foreach(explode("\n", $event_lines) as $event_line){
            list($file, $events) = sscanf($event_line, '%s %s');

            foreach(explode(',', $events) as $event) {

                //If we don't know about that event, continue
                if(!isset(static::$IN_EVENT_MAP[$event])){
                    continue;
                }

                $o_event = static::$IN_EVENT_MAP[$event];

                //If not subscribed, continue
                if(!in_array($o_event, $this->observer->getSubscribedEvents())){
                    continue;
                }

                //Otherwise, good to fire
                $this->observer->emit($o_event, [$file]);
            }

        }
    }

    public static function hasDependencies() {
        return `command -v inotifywait` !== null;
    }
}
