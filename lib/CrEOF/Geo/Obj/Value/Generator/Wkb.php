<?php

namespace CrEOF\Geo\Obj\Value\Generator;

/**
 * Class Wkb
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
class Wkb implements ValueGeneratorInterface
{
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function generate($value)
    {
        // Generate value
        return $value;
    }
}
