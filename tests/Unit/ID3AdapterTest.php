<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\ID3\ID3Adapter;


class ID3AdapterTest extends TestCase
{
    /**
     * @var
     */
    private $ID3Adapter;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->ID3Adapter = new ID3Adapter();
    }

    /**
     * Test for JSON output without error JSON with correct media file
     *
     * @return void
     */
    public function testWithMediaFile_resolvesToJSONWithoutErrorJSON()
    {
        $result = $this->ID3Adapter->analyze(__DIR__ . '/../Fixtures/Files/SampleVideo_1280x720_1mb.mp4');

        $this->assertJson($result);

        $asArray = json_decode($result);

        $hasError = array_key_exists('error', $asArray);

        $hasIDVersionKey = array_key_exists('GETID3_VERSION', $asArray);

        $this->assertFalse($hasError);

        $this->assertTrue($hasIDVersionKey);
    }

    /**
     * Test for JSON error message with non-media file
     *
     * @return void
     */
    public function testWithNonMediaFile_resolvesToErrorJSON()
    {
        $result = $this->ID3Adapter->analyze(__DIR__ . '/../Fixtures/Files/test.txt');

        $this->assertJson($result);

        $asArray = json_decode($result);

        $hasError = array_key_exists('error', $asArray);

        $hasIDVersionKey = array_key_exists('GETID3_VERSION', $asArray);

        $this->assertTrue($hasError);

        $this->assertTrue($hasIDVersionKey);
    }

    /**
     * Test for JSON error message with file that does not exist
     *
     * @return void
     */
    public function testWithFileNotExists_resolvesToErrorJSON()
    {
        $result = $this->ID3Adapter->analyze(__DIR__ . '/../Fixtures/Files/notexists.txt');

        $this->assertJson($result);

        $asArray = json_decode($result);

        $hasError = array_key_exists('error', $asArray);

        $hasIDVersionKey = array_key_exists('GETID3_VERSION', $asArray);

        $this->assertTrue($hasError);

        $this->assertTrue($hasIDVersionKey);
    }
}
