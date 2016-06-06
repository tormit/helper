<?php
/**
 * @author Tormi Talv <tormi.talv@ambientia.ee> 2016
 * @since 2016-06-06 12:59
 * @version 1.0
 */

namespace Tormit\Helper;

/**
 * Wrapper for PHP sleep functions.
 *
 * Class Sleeper
 * @package Tormit\Helper
 */
class Sleeper
{
    protected $microseconds = 1000;
    protected $retries = 1;

    public function seconds($seconds)
    {
        $this->microseconds = $seconds * 1000 * 1000;

        return $this;
    }

    public function milliseconds($milliseconds)
    {
        $this->microseconds = $milliseconds * 1000;

        return $this;
    }

    public function times($times)
    {
        $this->retries = $times;

        return $this;
    }

    /**
     * Waits for gives time x times until condition is true.
     *
     * @param callable $condition
     * @return bool
     */
    public function whileTrue(callable $condition)
    {
        while ($this->retries > 0) {
            if (!$condition()) {
                usleep($this->microseconds);
            } else {
                return true;
            }

            $this->retries--;
        }

        return false;
    }

    public static function wait()
    {
        return new self;
    }
}