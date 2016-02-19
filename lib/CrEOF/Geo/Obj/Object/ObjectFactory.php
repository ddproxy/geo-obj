<?php

namespace CrEOF\Geo\Obj\Object;

use CrEOF\Geo\Obj\AbstractObject;
use CrEOF\Geo\Obj\Value\ValueFactory;

namespace CrEOF\Geo\Obj\Types\Geometry;

/**
 * Class ObjectFactory
 *
 * The singleton class ObjectFactory creates geometry objects
 *
 * TODO would this be better in constructor of AbstractObject?
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
final class ObjectFactory
{
    /**
     * Private constructor to prevent instantiation
     */
    private function __construct()
    {

    }

    /**
     * @param mixed $value
     *
     * @return AbstractObject
     */
    public static function create($value)
    {

    }
}
