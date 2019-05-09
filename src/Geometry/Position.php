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

use Amylian\Spatial\Exception\InvalidArgumentException;
use Amylian\Spatial\Geometry\Base\BaseInterface;
use Amylian\Spatial\Geometry\Base\BaseInterfaceTrait;
use Amylian\Spatial\Geometry\Base\PositionInterface;

/**
 * Primitive Position
 *
 * @author Andreas Prucha, Abexto - Helicon Software Development <andreas.prucha@gmail.com>
 */
class Position implements BaseInterface, PositionInterface
{
    
    use BaseInterfaceTrait;

    protected $position = [0, 0];

    public function __construct(array $data)
    {
        $this->setPosition($data);
    }

    /**
     * Returns the position as array
     * @return array representing [x, y, z]
     */
    public function getPosition(): array
    {
        return $this->position;
    }

    /**
     * Sets the position
     * @param array|PositionInterface $position Array representing [x, y, z]
     */
    public function setPosition($position)
    {
        $cnt = count($position);
        $position = ($position instanceof PositionInterface) ? $position->getPosition() : $position;
        if (!is_array($position) || is_array($position) && count($position) < 2) {
            throw new InvalidArgumentException("Parameter \$position of setPosition expects either an array with at least 2 elements [x, y] or an instance of PositionInterface");
        }
        if (array_key_exists(2, $position) && $position[2] === null && $cnt < 4) {
            unset($position[2]);
        }
        $this->position = array_values($position);
    }
    
    /**
     * Returns the distance between this point and the passed point
     * @param \Amylian\Spatial\Geometry\Amylian\Spatial\Geometry\PointInterface $anotherPoint
     * @return float
     * @throws InvalidArgumentException
     */
    public function getDistanceTo(PositionInterface $anotherPoint): float
    {
        $c1 = $this->getPosition();
        $c2 = $anotherPoint->getPosition();
        // if z coordinates are set, then they must be set in both points
        if (isset($c1[2]) || $c2[2]) {
            if (!(isset($c1[2]) && $c2[2])) {
                throw new InvalidArgumentException('Cannot calculate distance between two points where one point has Z set, but the other does not');
            }
        }
        // Calculate distance
        return sqrt(
                (($c2[0] - $c1[0]) ** 2) +
                (($c2[1] - $c1[1]) ** 2) +
                ((($c2[2] ?? 0) - ($c1[2] ?? 0) ** 2))
        );
    }

    public function getX(): float
    {
        return $this->position[0];
    }

    public function getY(): float
    {
        return $this->position[1];
    }

    public function getZ(?float $default = null): float
    {
        return isset($this->position[2]) ?? $default;
    }

    public function setX(float $x)
    {
        $this->position[0] = $x;
    }

    public function setY($y)
    {
        $this->position[1] = $y;
    }

    public function setZ(?float $z = null)
    {
        $this->position[2] = $z;
    }

    public function toGeoJsonData()
    {
        $result = $this->position;
        if (array_key_exists(2, $result) && $result[2] === null) {
            unset($result[2]);
        }
        return $result;
    }

}
