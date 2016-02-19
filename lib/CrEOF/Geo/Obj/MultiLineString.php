<?php

namespace CrEOF\Geo\Obj;

/**
 * Class MultiLineString
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
class MultiLineString extends AbstractObject
{
    /**
     * @var array[] $lineStrings
     */
    protected $lineStrings = array();

    /**
     * @param AbstractLineString[]|array[] $rings
     * @param null|int                     $srid
     */
    public function __construct(array $rings, $srid = null)
    {
        $this->setLineStrings($rings)
            ->setSrid($srid);
    }

    /**
     * @param AbstractLineString|array[] $lineString
     *
     * @return self
     */
    public function addLineString($lineString)
    {
        $this->lineStrings[] = $this->validateLineStringValue($lineString);

        return $this;
    }

    /**
     * @return AbstractLineString[]
     */
    public function getLineStrings()
    {
        $lineStrings = array();

        for ($i = 0; $i < count($this->lineStrings); $i++) {
            $lineStrings[] = $this->getLineString($i);
        }

        return $lineStrings;
    }

    /**
     * @param int $index
     *
     * @return AbstractLineString
     */
    public function getLineString($index)
    {
        if ($index == -1) {
            $index = count($this->lineStrings) - 1;
        }

        $lineStringClass = $this->getNamespace() . '\LineString';

        return new $lineStringClass($this->lineStrings[$index], $this->srid);
    }

    /**
     * @param AbstractLineString[] $lineStrings
     *
     * @return self
     */
    public function setLineStrings(array $lineStrings)
    {
        $this->lineStrings = $this->validateMultiLineStringValue($lineStrings);

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::MULTILINESTRING;
    }

    /**
     * @return array[]
     */
    public function toArray()
    {
        return $this->lineStrings;
    }
}
