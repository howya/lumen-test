<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\ID3\ID3Adapter;


class ID3FeatureTest extends TestCase
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
    }

    /**
     * Test for correct message and code where resource does not exist
     *
     * @return void
     */
    public function testResourceNotExists_ReturnsJSONErrorAndCorrectCode()
    {

        $this->post('/api/v1.0/parseid4')
            ->seeStatusCode(404)
            ->seeJson(
                json_decode('{
                        "message": "Resource route not found"
                    }',
                    true)
            );
    }

    /**
     * Test for correct message and code when verb not POST
     *
     * @return void
     */
    public function testVerbNotExists_ReturnsJSONErrorAndCorrectCode()
    {
        $this->get('/api/v1.0/parseid3')
            ->seeStatusCode(405)
            ->seeJson(
                json_decode('{
                        "message": "Not allowed in this context"
                    }',
                    true)
            );
    }

    /**
     * Test for correct message and code when file key not present
     *
     * @return void
     */
    public function testFileKeyNotPresent_ReturnsJSONErrorAndCorrectCode()
    {
        $headers = ["Content-Type" => "multipart/form-data"];
        $payload = [];

        $this->post('/api/v1.0/parseid3', $payload, $headers)
            ->seeStatusCode(422)
            ->seeJson(
                json_decode('{
                        "message": "File not present or not valid. The file key must present a valid file as part of content type multipart/form-data."
                    }',
                    true)
            );
    }

    /**
     * Test for correct message and code when file key present but not file
     *
     * @return void
     */
    public function testFileKeyPresentButNotFile_ReturnsJSONErrorAndCorrectCode()
    {
        $headers = ["Content-Type" => "multipart/form-data"];
        $payload = ["file" => ""];

        $this->post('/api/v1.0/parseid3', $payload, $headers)
            ->seeStatusCode(422)
            ->seeJson(
                json_decode('{
                        "message": "File not present or not valid. The file key must present a valid file as part of content type multipart/form-data."
                    }',
                    true)
            );
    }

    /**
     * Test for correct message and code when file key present with file
     *
     * @return void
     */
    public function testFileKeyPresentWithFile_ReturnsID3JSON()
    {
        $headers = ["Content-Type" => "multipart/form-data"];
        $payload = [
            "file" => new \Illuminate\Http\UploadedFile(__DIR__ . '/../Fixtures/Files/SampleVideo_1280x720_1mb.mp4',
                'SampleVideo_1280x720_1mb.mp4', null, null, null, false)
        ];

        $this->post('/api/v1.0/parseid3', $payload, $headers)
            ->seeStatusCode(200);

    }


}
