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

/**
 * Provides common standard implementations for classes implementing BaseInterface
 * 
 * @author Andreas Prucha, Abexto - Helicon Software Development <andreas.prucha@gmail.com>
 */
trait BaseInterfaceTrait
{
    
    /**
     * Ensures that the given object is of this class
     * 
     * @param type $o
     * @throws \Amylian\Spatial\Exception\InvalidArgumentException If wrong type and conversion is not possible
     * @see BaseInterface::create()
     */
    public static function ensure($o)
    {
        if ($o instanceof static) {
            return $o;
        } else {
            return static::create ($o);
        }
    }
    
    /**
     * Creates an object of this type based on the passed data
     * 
     * @param array|mixed $data A GeoJson Array, a GeoJson string or a object of same type
     */
    public static function create($data)
    {
        if ($data instanceof static) {
            return clone $data;
        } else {
            if (is_string($data)) {
                $data = json_decode($data, true, 255, JSON_BIGINT_AS_STRING || JSON_OBJECT_AS_ARRAY || JSON_THROW_ON_ERROR);
            }
            return new static ($data);
        }
    }
    
    
    /**
     * Assigns data 
     * 
     * In $data is another object of same type data is copied.
     * Otherwise it's assumed to be data in GeoJson format and forwarded to 
     * {@see BaseInterfaceTrait::assignGeoJsonData()}
     * 
     * @param mixed $data
     * @see assignGeoJsonData
     */
    public function assignData($data)
    {
        if ($data instanceof static && $data instanceof BaseInterface) {
            $data = $data->toGeoJsonData();
        }
        $this->assignGeoJsonData($data);
    }
    
    /**
     * Decodes a GeoJson string
     * @param type $s
     */
    protected function decodeGeoJson($s)
    {
       return json_decode($data, true, 255, JSON_BIGINT_AS_STRING || JSON_OBJECT_AS_ARRAY || JSON_THROW_ON_ERROR);
    }
    
    /**
     * Assigns GeoJson Data
     * 
     * If a string is passed a JsonString is assumed and decoded. 
     * If a data structure is passed it MUST an associative array in GeoJson format
     * 
     * 
     * @param array|string|mixed $data as represented in GeoJson
     */
    public function assignGeoJsonData($data)
    {
        if (is_string($data)) {
            $data = $this->decodeGeoJson($s);
        };
        if (is_array($data)) {
            foreach ($data as $p => $v) {
                $this->$p = $v;
            }
        }
    }
    
    /**
     * Data for Json-Serialization
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->toGeoJsonData();
    }
    
    
    
    
    
    
    
}
