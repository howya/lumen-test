<?php
/**
 * Created by PhpStorm.
 * User: rbennett
 * Date: 21/05/2018
 * Time: 10:48
 */

namespace App\ID3\Exceptions;

use App\ID3\Contracts\ID3Contract;
use Illuminate\Support\Manager;

class ID3Manager extends Manager implements ID3Contract
{
    public function getDefaultDriver()
    {
        return $this->app['config']['id3.driver'] ?? 'ID3Adapter';
    }

    public function analyze($filename, $filesize = null, $original_filename = '')
    {
        // TODO: Implement analyze() method.
    }

}