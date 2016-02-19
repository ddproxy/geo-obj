<?php

namespace CrEOF\Geo\Obj;

/**
 * Class Point
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
class Point extends AbstractObject
{
    /**
     * @var float $x
     */
    protected $x;

    /**
     * @var float $y
     */
    protected $y;

    public function __construct()
    {
        $argv = $this->validateArguments(func_get_args());

        call_user_func_array(array($this, 'construct'), $argv);
    }

    /**
     * @param mixed $x
     *
     * @return self
     * @throws InvalidValueException
     */
    public function setX($x)
    {
        $parser = new Parser($x);

        try {
            $this->x = (float) $parser->parse();
        } catch (RangeException $e) {
            throw new InvalidValueException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (UnexpectedValueException $e) {
            throw new InvalidValueException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param mixed $y
     *
     * @return self
     * @throws InvalidValueException
     */
    public function setY($y)
    {
        $parser = new Parser($y);

        try {
            $this->y = (float) $parser->parse();
        } catch (RangeException $e) {
            throw new InvalidValueException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (UnexpectedValueException $e) {
            throw new InvalidValueException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getY()
    {
        return $this->y;
    }


    /**
     * @param mixed $latitude
     *
     * @return self
     */
    public function setLatitude($latitude)
    {
        return $this->setY($latitude);
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->getY();
    }

    /**
     * @param mixed $longitude
     *
     * @return self
     */
    public function setLongitude($longitude)
    {
        return $this->setX($longitude);
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->getX();
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::POINT;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array($this->x, $this->y);
    }

    /**
     * @param array $argv
     *
     * @return array
     * @throws InvalidValueException
     */
    protected function validateArguments(array $argv = null)
    {
        $argc = count($argv);

        if (1 == $argc && is_array($argv[0])) {
            return $argv[0];
        }

        if (2 == $argc) {
            if (is_array($argv[0]) && (is_numeric($argv[1]) || is_null($argv[1]) || is_string($argv[1]))) {
                $argv[0][] = $argv[1];

                return $argv[0];
            }

            if ((is_numeric($argv[0]) || is_string($argv[0])) && (is_numeric($argv[1]) || is_string($argv[1]))) {
                return $argv;
            }
        }

        if (3 == $argc) {
            if ((is_numeric($argv[0]) || is_string($argv[0])) && (is_numeric($argv[1]) || is_string($argv[1])) && (is_numeric($argv[2]) || is_null($argv[2]) || is_string($argv[2]))) {
                return $argv;
            }
        }

        array_walk($argv, function (&$value) {
            if (is_array($value)) {
                $value = 'Array';
            } else {
                $value = sprintf('"%s"', $value);
            }
        });

        throw new InvalidValueException(sprintf('Invalid parameters passed to %s::%s: %s', get_class($this), '__construct', implode(', ', $argv)));
    }

    /**
     * @param int      $x
     * @param int      $y
     * @param null|int $srid
     */
    protected function construct($x, $y, $srid = null)
    {
        $this->setX($x)
            ->setY($y)
            ->setSrid($srid);
    }

}
