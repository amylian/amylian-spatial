<?php

/*
 * BSD 3-Clause License
 * 
 * Copyright (c) 2019, Abexto - Helicon Software Development / Amylian Project
 *  
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 * 
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 * 
 * * Neither the name of the copyright holder nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 */

namespace Amylian\Spatial\Geometry\Base;

use Amylian\Spatial\Exception\InvalidArgumentException;

/**
 * Description of AbstractTypedObject
 *
 * @author Andreas Prucha, Abexto - Helicon Software Development <andreas.prucha@gmail.com>
 */
class AbstractGeoJsonObject implements GeoJsonObjectInterface
{

    use BaseInterfaceTrait;

    const TYPE_NAME = null;

    /**
     * @var array Array of unknown member variables assigned
     */
    protected $_foreignMembers = [];

    /**
     * Constructor
     */
    public function __construct($data)
    {
        $this->assignData($data);
    }

    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } else {
            return $this->_foreignMembers[$name];
        }
    }

    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } else {
            $this->_foreignMembers[$name] = $value;
        }
    }

    public function __isset($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return ($this->$getter() !== null);
        } else {
            isset($this->_foreignMembers[$name]);
        }
    }

    /**
     * @inheritDoc
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE_NAME;
    }

    /**
     * @inheritDoc
     */
    public function toGeoJsonData(): array
    {
        return array_merge([
            'type' => $this->getType()
                ],
                $this->_foreignMembers
        );
    }

    public function assignGeoJsonData($data)
    {
        $type = $data['type'] ?? '???';
        if (strcasecmp($type, $this->getType()) !== 0) {
            throw new InvalidArgumentException("Could not assign GeoJson data. Expected Type: '{$this->getType()}', but '$type' given");
        }
        unset($data['type']);
        foreach ($data as $p => $v) {
            $this->$p = $v;
        }
    }

    public static function createFromGeoJsonData($geoJson)
    {
        return new static($geoJson);
    }

}
