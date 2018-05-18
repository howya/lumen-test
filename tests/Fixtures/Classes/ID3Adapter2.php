<?php

namespace Tests\Fixtures\Classes;

use App\ID3\Contracts\ID3Contract;

/**
 * An adapter class to abstract getID3
 *
 * Class ID3Adapter
 * @package App\ID3
 */
class ID3Adapter2 implements ID3Contract
{
    public function analyze($filename, $filesize = null, $original_filename = '')
    {
        return;
    }
}