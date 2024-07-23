<?php

namespace App\Http\Controllers\Helpers;

class fileProcessingHelper
{
	public function getFileInfo($file)
	{
		$name = $file->getClientOriginalName();
		$mimetype = $file->getClientMimeType();
		$size = $file->getClientSize();
		return [
			'name' => $name,
            'mimetype' => $mimetype,
            'size' => $size
        ];
    }
}
