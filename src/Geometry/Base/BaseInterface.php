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
 * Base interface all objects *MUST* implement
 * @author Andreas Prucha, Abexto - Helicon Software Development <andreas.prucha@gmail.com>
 */
interface BaseInterface
{
    /**
     * Ensures that the given object has the right type
     * 
     * It MUST return the object as is if it's the correct type
     * It MUST create a object of this type based on the data given in $o if possible
     * It MUST throw an exception if conversion is not possible
     * 
     * It SHOULD do the conversion by calling static::create()
     * 
     * @param type $o
     * @throws \Amylian\Spatial\Exception\InvalidArgumentException If wrong type and conversion is not possible
     * @see BaseInterface::create()
     */
    public static function ensure($o);
    
    /**
     * Assigns data 
     * 
     * A implementation MUST support a GeoJson associative array
     * A implementation SHOULD support assignment of another equal
     * A implementation SHOULD support GeoJson as a string
     * 
     * @param mixed $data
     */
    public function assignData($data);
    
    /**
     * Assigns GeoJson Data
     * 
     * If it's structured data it MUST be passed as associative array representing the Json Structure
     * 
     * @param array|mixed $data
     */
    public function assignGeoJsonData($data);
    
    /**
     * Creates an object of this type based on the passed data
     * 
     * If data is an instance of the required object type it *MUST* clone the object
     * It MUST handle data as GeoJson data unless it can detect it as Primitive. If it's
     * GeoJson Data it MUST call createFromGeoJsonData in order to create the object
     * 
     * @param type $data
     */
    public static function create($data);
    
    /**
     * Returns the the object as in GeoJson representation
     * 
     * For structured data the implementation MUST provide data as an associative array
     * 
     * @return array|mixed
     */
    public function toGeoJsonData();
    
    
}
