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
    protected $escalateFactor = 1.0;

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
     * Wait time is cumulatively multiplied by this factor.
     * Example: For sleep time 2s and 1.5x escalate, you get sleep times: 2.00 3.00 4.50 6.75 10.13 etc.
     *
     * @param $escalateFactor
     * @return $this
     */
    public function escalate($escalateFactor)
    {
        $this->escalateFactor = $escalateFactor;

        return $this;
    }

    /**
     * Waits for gives time x times until condition is true.
     *
     * @param callable $condition Callback params (int $attemptNumber)
     * @return bool
     */
    public function whileTrue(callable $condition)
    {
        $attempt = 1;
        while ($this->retries > 0) {
            if (!$condition($attempt)) {
                usleep($this->microseconds);
            } else {
                return true;
            }

            $this->retries--;
            $this->microseconds *= $this->escalateFactor;
            $attempt++;
        }

        return false;
    }

    public static function wait()
    {
        return new self;
    }
}