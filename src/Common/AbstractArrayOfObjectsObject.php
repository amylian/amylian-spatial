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

namespace Amylian\Spatial\Common;

/**
 * Description of AbstractArrayOfObjectsObject
 *
 * @author Andreas Prucha, Abexto - Helicon Software Development <andreas.prucha@gmail.com>
 */
abstract class AbstractArrayOfObjectsObject extends \Amylian\Utils\ArrayObject
{
    
    public function __construct($input = array(), int $flags = 0, string $iterator_class = "ArrayIterator")
    {
        parent::__construct($this->aaoCheckInput($input), $flags, $iterator_class);
    }
    
    /**
     * Checks if the given data is of valid type and converts if necessary and possible
     * @param type $index
     * @param \Amylian\Spatial\Common\aooRequiredClass $newval
     * @return void
     */
    abstract protected function aooAssign($o): object;
    
    protected function aaoCheckInput(array $input = []): array 
    {
        foreach ($input as $i => &$v /* !Value by reference! */) {
            $v = $this->aooAssign($v);
        }
        return $input;
    }
    
    public function append($value): void
    {
        parent::append($this->aooAssign($value));
    }
    
    public function exchangeArray($input): array
    {
        return parent::exchangeArray($this->aaoCheckInput($checkedInput));
    }
    
    public function offsetSet($index, $newval): void
    {
        parent::offsetSet($index, $this->aooAssign($newval));
    }
}
