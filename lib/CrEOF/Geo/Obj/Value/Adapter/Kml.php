<?php

namespace CrEOF\Geo\Obj\Value\Adapter;

use CrEOF\Geo\Obj\Exception\UnsupportedTypeException;

/**
 * Class Kml
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
class Kml implements ValueAdapterInterface
{
    /**
     * @param $value
     *
     * @return mixed
     * @throws UnsupportedTypeException
     */
    public function process($value)
    {
        // Check if supported type
        if (false) {
            throw new UnsupportedTypeException();
        }

        // Process value
        return $value;
    }
}
