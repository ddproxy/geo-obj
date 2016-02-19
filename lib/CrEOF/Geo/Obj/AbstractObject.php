<?php

namespace CrEOF\Geo\Obj;

use CrEOF\Geo\Obj\Value\ValueFactory;

/**
 * Abstract geo object
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
abstract class AbstractObject implements GeometryInterface
{
    /**
     * @var array
     */
    protected $properties;

    public function __call($name, $arguments)
    {
        // toWkt, toWkb, toGeoJson, etc.
        if (0 === strpos($name, 'to') && 1 === count($arguments)) {
            ValueFactory::generate($arguments[0], substr($name, 2));
        }
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getProperty($name)
    {
        return $this->properties[$name];
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function setProperty($name, $value)
    {
        $this->properties[$name] = $value;
    }


    /**
     * @var int
     */
    protected $srid;

    /**
     * @return array
     */
    abstract public function toArray();

    /**
     * @return string
     */
    public function __toString()
    {
        $type   = strtoupper($this->getType());
        $method = 'toString' . $type;

        return $this->$method($this->toArray());
    }

    /**
     * @return string
     */
    public function toJson()
    {
        $json['type'] = $this->getType();
        $json['coordinates'] = $this->toArray();
        return json_encode($json);
    }

    /**
     * @return null|int
     */
    public function getSrid()
    {
        return $this->srid;
    }

    /**
     * @param mixed $srid
     *
     * @return self
     */
    public function setSrid($srid)
    {
        if ($srid !== null) {
            $this->srid = (int) $srid;
        }

        return $this;
    }

    /**
     * @param AbstractPoint|array $point
     *
     * @return array
     * @throws InvalidValueException
     */
    protected function validatePointValue($point)
    {
        switch (true) {
            case ($point instanceof AbstractPoint):
                return $point->toArray();
                break;
            case (is_array($point) && count($point) == 2 && is_numeric($point[0]) && is_numeric($point[1])):
                return array_values($point);
                break;
            default:
                throw new InvalidValueException(sprintf('Invalid %s Point value of type "%s"', $this->getType(), (is_object($point) ? get_class($point) : gettype($point))));
        }
    }

    /**
     * @param AbstractLineString|array[] $ring
     *
     * @return array[]
     * @throws InvalidValueException
     */
    protected function validateRingValue($ring)
    {
        switch (true) {
            case ($ring instanceof AbstractLineString):
                $ring = $ring->toArray();
                break;
            case (is_array($ring)):
                break;
            default:
                throw new InvalidValueException(sprintf('Invalid %s LineString value of type "%s"', $this->getType(), (is_object($ring) ? get_class($ring) : gettype($ring))));
        }

        $ring = $this->validateLineStringValue($ring);

        if ($ring[0] !== end($ring)) {
            throw new InvalidValueException(sprintf('Invalid polygon, ring "(%s)" is not closed', $this->toStringLineString($ring)));
        }

        return $ring;
    }

    /**
     * @param AbstractLineString|AbstractPoint[]|array[] $points
     *
     * @return array[]
     */
    protected function validateMultiPointValue($points)
    {
        if ($points instanceof GeometryInterface) {
            $points = $points->toArray();
        }

        foreach ($points as &$point) {
            $point = $this->validatePointValue($point);
        }

        return $points;
    }

    /**
     * @param AbstractLineString|AbstractPoint[]|array[] $lineString
     *
     * @return array[]
     */
    protected function validateLineStringValue($lineString)
    {
        return $this->validateMultiPointValue($lineString);
    }

    /**
     * @param AbstractLineString[] $rings
     *
     * @return array
     */
    protected function validatePolygonValue(array $rings)
    {
        foreach ($rings as &$ring) {
            $ring = $this->validateRingValue($ring);
        }

        return $rings;
    }

    /**
     * @param AbstractPolygon[] $polygons
     *
     * @return array
     */
    protected function validateMultiPolygonValue(array $polygons)
    {
        foreach ($polygons as &$polygon) {
            if ($polygon instanceof GeometryInterface) {
                $polygon = $polygon->toArray();
            }
            $polygon = $this->validatePolygonValue($polygon);
        }

        return $polygons;
    }

    /**
     * @param AbstractLineString[] $lineStrings
     *
     * @return array
     */
    protected function validateMultiLineStringValue(array $lineStrings)
    {
        foreach ($lineStrings as &$lineString) {
            $lineString = $this->validateLineStringValue($lineString);
        }

        return $lineStrings;
    }

    /**
     * @return string
     */
    protected function getNamespace()
    {
        $class = get_class($this);

        return substr($class, 0, strrpos($class, '\\') - strlen($class));
    }

    /**
     * @param array $point
     *
     * @return string
     */
    private function toStringPoint(array $point)
    {
        return vsprintf('%s %s', $point);
    }

    /**
     * @param array[] $multiPoint
     *
     * @return string
     */
    private function toStringMultiPoint(array $multiPoint)
    {
        $strings = array();

        foreach ($multiPoint as $point) {
            $strings[] = $this->toStringPoint($point);
        }

        return implode(',', $strings);
    }

    /**
     * @param array[] $lineString
     *
     * @return string
     */
    private function toStringLineString(array $lineString)
    {
        return $this->toStringMultiPoint($lineString);
    }

    /**
     * @param array[] $multiLineString
     *
     * @return string
     */
    private function toStringMultiLineString(array $multiLineString)
    {
        $strings = null;

        foreach ($multiLineString as $lineString) {
            $strings[] = '(' . $this->toStringLineString($lineString) . ')';
        }

        return implode(',', $strings);
    }

    /**
     * @param array[] $polygon
     *
     * @return string
     */
    private function toStringPolygon(array $polygon)
    {
        return $this->toStringMultiLineString($polygon);
    }

    /**
     * @param array[] $multiPolygon
     *
     * @return string
     */
    private function toStringMultiPolygon(array $multiPolygon)
    {
        $strings = null;

        foreach ($multiPolygon as $polygon) {
            $strings[] = '(' . $this->toStringPolygon($polygon) . ')';
        }

        return implode(',', $strings);
    }
}
