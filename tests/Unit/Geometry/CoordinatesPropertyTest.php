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

namespace Amylian\Spatial\Testing\Unit\Geometry;

/**
 * Description of ArrayOfArrayOfPositions
 *
 * @author Andreas Prucha, Abexto - Helicon Software Development <andreas.prucha@gmail.com>
 */
class CoordinatesPropertyTest extends \PHPUnit\Framework\TestCase
{
    
    public function test2L()
    {
        $ap = new \Amylian\Spatial\Testing\Misc\Coordinates2L([[1, 1], [2, 2], [3, 3]]);
        $ret = $ap->toGeoJsonData();
        $this->assertEquals(json_encode([[1, 1], [2, 2], [3, 3]]), 
                json_encode($ret), 'Got: '.json_encode($ret));
        $this->assertInstanceOf(\Amylian\Spatial\Geometry\Base\PositionInterface::class, $ap[1]);
        $ap[2] = [2, 2, 666];
        $this->assertEquals([2, 2, 666], $ap[2]->getPosition());
    }
    
    public function test3L()
    {
        $ap = new \Amylian\Spatial\Testing\Misc\Coordinates3L([
            [[1, 1], [1, 2], [1, 3]],
            [[2, 1], [2, 2], [2, 3]]]);
        $this->assertEquals(json_encode([[1, 1], [1, 2], [1, 3]]), 
                json_encode($ap->getArrayCopy()[0]), 'Got: '.json_encode($ap->getArrayCopy()[0]));
        $this->assertEquals(json_encode([[2, 1], [2, 2], [2, 3]]), 
                json_encode($ap->getArrayCopy()[1]), 'Got: '.json_encode($ap->getArrayCopy()[1]));
        $this->assertInstanceOf(\Amylian\Spatial\Testing\Misc\Coordinates2L::class, $ap[1]);
        $this->assertInstanceOf(\Amylian\Spatial\Geometry\Base\PositionInterface::class, $ap[1][1]);
    }
    
}
