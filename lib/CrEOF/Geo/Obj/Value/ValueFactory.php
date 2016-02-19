<?php

namespace CrEOF\Geo\Obj\Value;

use CrEOF\Geo\Obj\Exception\UnsupportedTypeException;
use CrEOF\Geo\Obj\Value\Adapter\ValueAdapterInterface;
use CrEOF\Geo\Obj\Value\Generator\ValueGeneratorInterface;

/**
 * Class ValueFactory
 *
 * The singleton class ValueFactory converts from/to input and output values in various data formats
 * to/from internal type representation using adapter classes.
 *
 * @author  Derek J. Lambert <dlambert@dereklambert.com>
 * @license http://dlambert.mit-license.org MIT
 */
final class ValueFactory
{
    /**
     * @var ValueAdapterInterface[]
     */
    private static $adapters;

    /**
     * @var ValueGeneratorInterface[]
     */
    private static $generators;

    /**
     * Private constructor to prevent instantiation
     */
    private function __construct()
    {

    }

    /**
     * @param             $value
     * @param null|string $typeHint
     *
     * @return mixed
     * @throws UnsupportedTypeException
     */
    public static function process($value, $typeHint = null)
    {
        if (null !== $typeHint) {
            return self::$adapters[$typeHint]->process($value);
        }

        foreach (self::$adapters as $type => $adapter) {
            try {
                return $adapter->process($value);
            } catch (UnsupportedTypeException $e) {
                // Try next adapter
            }
        }

        throw new UnsupportedTypeException();
    }

    /**
     * @param        $value
     * @param string $type
     *
     * @return mixed
     * @throws UnsupportedTypeException
     */
    public static function generate($value, $type)
    {
        if (! array_key_exists($type, self::$generators)) {
            throw new UnsupportedTypeException();
        }

        return self::$generators[$type]->generate($value);
    }

    /**
     * @return ValueAdapterInterface[]
     */
    public static function getAdapters()
    {
        return self::$adapters;
    }

    /**
     * @param ValueAdapterInterface $adapter ValueAdapterInterface instance
     * @param string                $format  Format supported by adapter
     */
    public static function addAdapter(ValueAdapterInterface $adapter, $format)
    {
        self::$adapters[$format] = $adapter;
    }

    /**
     * @return ValueGeneratorInterface[]
     */
    public static function getGenerators()
    {
        return self::$generators;
    }

    /**
     * @param ValueGeneratorInterface $generator ValueGeneratorInterface
     * @param string                  $format    Format supported by generator
     */
    public static function addGenerator(ValueGeneratorInterface $generator, $format)
    {
        self::$generators[$format] = $generator;
    }
}
