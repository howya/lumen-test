# Think Digital Group - Lumen Test

This repository represents the completed Lumen test for Think Digital Group.

The solution has been designed to allow a media file to be uploaded via a POST request via a multipart/form-data request to the endpoint:

```/api/v1.0/parseid3```

Please ensure that the media file is associated with the form data key ```file```


## Installation

To install, clone this repository and run ```composer install```


 
## Tests

To test run ```composer test```


## Notes

The getID3 functionality has been implemented via an adapter. The adapter is bound via the illuminate\support\manager factory and allows for dependency inversion.

Some issues were had with JSON encoding the getID3 results due to some result array string values not being UTF8 encoded. The workaround and explanation for this is documented within ```\App\ID3\ID3Adapter``` class.
