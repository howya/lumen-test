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
        $asArray = $this->ID3Adapter->analyze(__DIR__ . '/../Fixtures/Files/SampleVideo_1280x720_1mb.mp4');

        $hasIDVersionKey = array_key_exists('GETID3_VERSION', json_decode($asArray['result'], true));

        $this->assertJson($asArray['result']);
        $this->assertTrue($asArray['status']);

        $this->assertTrue($hasIDVersionKey);
    }

    /**
     * Test for JSON error message with non-media file
     *
     * @return void
     */
    public function testWithNonMediaFile_resolvesToErrorJSON()
    {
        $asArray = $this->ID3Adapter->analyze(__DIR__ . '/../Fixtures/Files/test.txt');

        $hasIDVersionKey = array_key_exists('GETID3_VERSION', json_decode($asArray['result'], true));

        $this->assertJson($asArray['result']);
        $this->assertFalse($asArray['status']);

        $this->assertFalse($hasIDVersionKey);
    }

    /**
     * Test for JSON error message with file that does not exist
     *
     * @return void
     */
    public function testWithFileNotExists_resolvesToErrorJSON()
    {
        $asArray = $this->ID3Adapter->analyze(__DIR__ . '/../Fixtures/Files/notexists.txt');

        $hasIDVersionKey = array_key_exists('GETID3_VERSION', json_decode($asArray['result'], true));

        $this->assertJson($asArray['result']);
        $this->assertFalse($asArray['status']);

        $this->assertFalse($hasIDVersionKey);
    }
}
