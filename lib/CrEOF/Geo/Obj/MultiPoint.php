<?php

namespace CrEOF\Geo\Obj;

/**
 * Class MultiPoint
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
class MultiPoint extends AbstractObject
{

    /**
     * @var array[] $points
     */
    protected $points = array();

    /**
     * @param AbstractPoint[]|array[] $points
     * @param null|int                $srid
     */
    public function __construct(array $points, $srid = null)
    {
        $this->setPoints($points)
            ->setSrid($srid);
    }

    /**
     * @param AbstractPoint|array $point
     *
     * @return self
     * @throws InvalidValueException
     */
    public function addPoint($point)
    {
        $this->points[] = $this->validatePointValue($point);

        return $this;
    }

    /**
     * @return AbstractPoint[]
     */
    public function getPoints()
    {
        $points = array();

        for ($i = 0; $i < count($this->points); $i++) {
            $points[] = $this->getPoint($i);
        }

        return $points;
    }

    /**
     * @param AbstractPoint[]|array[] $points
     *
     * @return self
     */
    public function setPoints($points)
    {
        $this->points = $this->validateMultiPointValue($points);

        return $this;
    }

    /**
     * @param int $index
     *
     * @return AbstractPoint
     */
    public function getPoint($index)
    {
        switch ($index) {
            case -1:
                $point = $this->points[count($this->points) - 1];
                break;
            default:
                $point = $this->points[$index];
                break;
        }

        $pointClass = $this->getNamespace() . '\Point';

        return new $pointClass($point[0], $point[1], $this->srid);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::MULTIPOINT;
    }

    /**
     * @return array[]
     */
    public function toArray()
    {
        return $this->points;
    }
}
