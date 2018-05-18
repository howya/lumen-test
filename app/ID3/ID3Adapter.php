<?php

namespace App\ID3;

use App\ID3\Contracts\ID3Contract;
use getID3;

/**
 * An adapter class to abstract getID3
 *
 * Class ID3Adapter
 * @package App\ID3
 */
class ID3Adapter implements ID3Contract
{
    /**
     * @param $filename
     * @param null $filesize
     * @param string $original_filename
     * @return mixed|string
     * @throws \getid3_exception
     */
    public function analyze($filename, $filesize = null, $original_filename = '')
    {
        //Create the getID3 instance
        $getID3 = new getID3();

        //Process the file
        try {
            $processResult = $getID3->analyze($filename);
        } catch (\Exception $e) {
            return false;
        }

        //Convert any non UTF8 strings to UTF8 prior to JSON encode
        array_walk_recursive($processResult, '\App\ID3\ID3Adapter::encode_items');

        //Return the JSON encoded result
        return json_encode($processResult);
    }

    /**
     * Tests demonstrated that getID3->analyze returned an array structure that
     * contained non UTF8 strings. As such the returned array could not be JSON encoded.
     *
     * To resolve this all non UTF8 string are converted to UTF8. If a source encoding is identified then
     * conversion should not cause character corruption. If no source encoding is detected then the conversion
     * is forced to UTF8. It is acknowledged that this can cause character corruption. Without better understanding
     * the ID3 implementation it has not been possible to resolve this.
     *
     * @param $item
     * @param $key
     */
    public static function encode_items(&$item, $key)
    {
        if (is_string($item) && !mb_detect_encoding($item, 'UTF-8', true)) {
            $item = mb_detect_encoding($item) ? mb_convert_encoding($item, 'UTF-8',
                mb_detect_encoding($item)) : mb_convert_encoding($item, 'UTF-8');
        }
    }

}