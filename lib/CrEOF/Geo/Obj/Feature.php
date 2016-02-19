<?php

namespace CrEOF\Geo\Obj;

/**
 * Class Feature
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
class Feature extends AbstractObject
{
    /**
     * @var GeometryInterface $geometry
     */
    private $geometry;

    /**
     * @var array $property
     */
    private $property;

    /**
     * @return string
     */
    public function getType()
    {
        return self::FEATURE;
    }

    /**
     * @param GeometryInterface $geometry
     * @return $this
     */
    public function setGeometry(GeometryInterface $geometry)
    {
        $this->geometry = $geometry;
        return $this;
    }

    /**
     * @return GeometryInterface
     */
    public function getGeometry()
    {
        return $this->geometry;
    }
    /**
     * @param $property
     * @return mixed
     */
    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }


    /**
     * @return array
     */
    public function getProperty()
    {
        return $this->property;
    }
}
