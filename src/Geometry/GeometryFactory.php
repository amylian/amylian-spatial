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

namespace Amylian\Spatial\Geometry;

/**
 * Description of GeometryFactory
 *
 * @author Andreas Prucha, Abexto - Helicon Software Development <andreas.prucha@gmail.com>
 */
class GeometryFactory
{
    use GeoJsonSupportTrait;
    
    static $types = [
        'Position' => Position::class,
        'Point' => Point::class
    ];
            
    protected static function getClassOfType(string $type)
    {
        $type = ucfirst($type);
        if (isset(static::$types[$type])) {
            return static::$types[$type];
        } else {
            throw new InvalidArgumentException('Unknown Type: '.$type.' Valid types are '.implode(', ', array_keys($types[$type])));
        }
    }
            
    public static function createFromCoordinates(string $type, $coordinates): Base\BaseCoordinatesPropertyInterface
    {
        $class = static::getClassOfType($type);
        if (is_subclass_of($class, Base\BaseCoordinatesPropertyInterface::class)) {
            return $class::createFromCoordinates($class);
        } else {
            throw new InvalidArgumentException("Type: '$type' ('$class') does not support coordinates");
        }
    }
    
    public static function createFromGeoJson($data, $untypedDefaultType = 'Position') 
    {
        $data = static::ensureAssocArray($data, false);
        $class = static::getClassOfType($data['type'] ?? $untypedDefaultType);
        return $class::createFromGeoJson($data);
    }
            
}
