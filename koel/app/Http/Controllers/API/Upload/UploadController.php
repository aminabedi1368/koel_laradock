<?php

namespace App\Http\Controllers\API\Upload;

use App\Models\Setting;
use Upload;
use App\Http\Requests\API\Upload\UploadRequest;
use App\Facades\Media;
use Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UploadController extends Controller
{

    public function Upload(UploadRequest $request)
    {
        $destinationPath = null;
        $AlbumName= $request->AlbumName;
        $destinationPath = $destinationPath ?: Setting::get('media_path').'/'.$AlbumName;
        if ($request->hasFile('MP3File')) {
            $files = $request->file('MP3File');
            foreach($files as $file){

                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                if(!$file->move($destinationPath, $filename )) {
                    return $this->errors(['message' => 'Error saving the file.', 'code' => 400]);
                }
            }
        }
        Media::sync();

        return response()->json(['success' => true], 200);

    }

}
