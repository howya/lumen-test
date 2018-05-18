<?php

namespace App\ID3\Contracts;

/**
 * A contract for an ID3 Adapter, allowing substitution of underlying ID3 concretion
 *
 * Interface ID3Contract
 * @package App\ID3\Contracts
 */
interface ID3Contract
{
    /**
     * @param $filename
     * @param null $filesize
     * @param string $original_filename
     * @return mixed
     */
    public function analyze($filename, $filesize = null, $original_filename = '');
}