<?php

namespace CrEOF\Geo\Obj;

/**
 * Class FeatureCollection
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
class FeatureCollection extends AbstractObject implements \ArrayAccess
{
    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    /**
     * @var array
     */
    private $features;

    /**
     * @return string
     */
    public function getType()
    {
        return self::FEATURECOLLECTION;
    }
}
