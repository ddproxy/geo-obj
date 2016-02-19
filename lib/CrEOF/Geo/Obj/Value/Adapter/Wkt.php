<?php
namespace CrEOF\Geo\Obj\Value\Adapter;

use CrEOF\Geo\Obj\Exception\UnsupportedTypeException;
use CrEOF\Geo\WKT\Parser;

/**
 * Class Wkt
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
class Wkt implements ValueAdapterInterface
{
    /**
     * @var Parser
     */
    private static $parser;

    public function __construct()
    {
        self::$parser = new Parser();
    }

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
        return self::$parser->parse($value);
    }
}
