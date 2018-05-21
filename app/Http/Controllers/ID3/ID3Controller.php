<?php

namespace App\Http\Controllers\ID3;

use App\Http\Controllers\Controller;
use App\ID3\ID3Manager;
use Illuminate\Http\Request;
use App\ID3\Exceptions\InvalidFileException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ID3Controller extends Controller
{
    /**
     * @var $ID3Manager
     */
    private $ID3Manager;

    /**
     * Create a new controller instance.
     *
     * The ID3Manager provides a factory for ID3Drivers.
     * This enables dependency inversion.
     *
     * @param ID3Manager $ID3Manager
     */
    public function __construct()
    {
        $this->ID3Manager = new ID3Manager(app());
    }

    /**
     * @param Request $request
     * @return string
     * @throws InvalidFileException
     * @throws \App\ID3\Exceptions\InvalidFileException
     */
    public function post(Request $request)
    {
        //Check that file key exists and that file is valid. This could have been partially
        //implemented via validate() but validate() does not verify file so implemented both
        //checks here
        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            throw new InvalidFileException(422,
                'File not present or not valid. The file key must present a valid file as part of content type multipart/form-data.',
                null, array(), 422);
        }

        //Get the original file name
        $fileName = $request->file('file')->getClientOriginalName();

        //Move the file to the file location specified in id3 config
        $request->file('file')->move(config('id3.file_storage'), $fileName);

        //Build the file location to pass to ID3 Adapter
        $fileLocation = config('id3.file_storage') . '/' . $fileName;

        //Process the file with ID3 Adapter
        $processResult = $this->ID3Manager->analyze($fileLocation);

        //Delete the file after processing
        unlink($fileLocation);

        if ($processResult) {
            //Return a json response with code HTTP 200
            return response($processResult, 200, ['Content-Type' => 'application/json']);
        } else {
            throw new HttpException(422, "Unable to process file for ID3 information.");
        }
    }
}

