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
 * Represents a position object
 *
 * @author Andreas Prucha, Abexto - Helicon Software Development <andreas.prucha@gmail.com>
 */
interface PositionInterface extends BaseInterface
{
    /**
     * Returns the distance between this point and the passed point
     * @param \Amylian\Spatial\Geometry\Amylian\Spatial\Geometry\PointInterface $anotherPoint
     * @return float
     * @throws InvalidArgumentException
     */
    public function getDistanceTo(PositionInterface $anotherPoint): float;
    /**
     * Returns the position as an array
     * @return array  0: x, 1: y, 2: z
     */
    public function getPosition(): array;
    /**
     * Sets the position
     * @param PositionInterface|array $position
     */
    public function setPosition($position);
    
    /**
     * Returns X
     * @return float
     */
    public function getX(): float;
    /**
     * Returns Y
     * @return float
     */
    public function getY(): float;
    /**
     * Returns Z
     * @return float
     */
    public function getZ(?float $default = null): ?float;
    /**
     * Sets X
     * @param float $x
     */
    public function setX(float $x);
    /**
     * Sets Y
     * @param float $x
     */
    public function setY(float $y);
    /**
     * Sets Z
     * @param float $x
     */
    public function setZ(?float $z);
}
