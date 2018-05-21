<?php

namespace App\ID3;

use App\ID3\Contracts\ID3Contract;
use Illuminate\Support\Manager;

class ID3Manager extends Manager implements ID3Contract
{
    /**
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['id3.driver.name'] ?? 'ID3Adapter';
    }

    /**
     * @return ID3Adapter
     */
    public function createID3AdapterDriver()
    {
        return new ID3Adapter();
    }

    /**
     * @param $filename
     * @param null $filesize
     * @param string $original_filename
     * @return mixed
     */
    public function analyze($filename, $filesize = null, $original_filename = '')
    {
        return $this->driver()->analyze($filename, $filesize, $original_filename);
    }
}