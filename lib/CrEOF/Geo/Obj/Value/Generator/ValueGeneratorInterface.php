<?php

namespace CrEOF\Geo\Obj\Value\Generator;

/**
 * Interface ValueGeneratorInterface
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
interface ValueGeneratorInterface
{
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function generate($value);
}
