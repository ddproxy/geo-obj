<?php

namespace CrEOF\Geo\Obj;

/**
 * GeoJson wrapper for Geometry
 *
 * @author  Jon West <ddproxy@gmail.com>
 * @license http://ddproxy.mit-license.org MIT
 */
abstract class GeoJson implements \JsonSerializable
{
    abstract public function getType();
    abstract public function getCrs();
    abstract public function getSrid();
    abstract public function get();

    /**
     * @see http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize()
    {
        $json = array('type' => $this->getType());
        if (isset($this->crs)) {
            $json['crs'] = $this->crs->jsonSerialize();
        }
        if (isset($this->boundingBox)) {
            $json['bbox'] = $this->boundingBox->jsonSerialize();
        }
        return $json;
    }
}
