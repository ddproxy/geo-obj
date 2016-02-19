<?php

namespace CrEOF\Geo\Obj\Value\Adapter;

use CrEOF\Geo\Obj\Exception\UnsupportedTypeException;

/**
 * Interface ValueAdapterInterface
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
interface ValueAdapterInterface
{

    /**
     * @param $value
     *
     * @return mixed
     * @throws UnsupportedTypeException
     */
    public function process($value);
}
