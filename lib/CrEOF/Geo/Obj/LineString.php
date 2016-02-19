<?php

namespace CrEOF\Geo\Obj;


/**
 * Class LineString
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
class LineString extends AbstractObject
{
    /**
     * @return string
     */
    public function getType()
    {
        return self::LINESTRING;
    }

    /**
     * @return bool
     */
    public function isClosed()
    {
        return $this->points[0] === $this->points[count($this->points) - 1];
    }
}
