<?php
/**
 * Created by PhpStorm.
 * User: aminabedi
 * Date: 3/3/2018 AD
 * Time: 12:53
 */


namespace App\Http\Requests\API\Upload;

use App\Http\Requests\API\Request as BaseRequest;

class UploadRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return config('koel.upload.allow');
    }

    public function rules()
    {
            return ['AlbumName' => 'string|required',
                    'MP3File'   => 'required'
                    ];
    }

    public function messages()
    {
        return [
            'AlbumName' => 'AlbumName is required',
            'MP3File'   => 'MP3File is required',
        ];
    }
}
