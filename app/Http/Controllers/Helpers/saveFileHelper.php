<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Models\file_upload;

use Illuminate\Support\Facades\Auth;

class saveFileHelper
{
	public function __construct(fileProcessingHelper $fileHelper)
	{
		$this->fileHelper = $fileHelper;
	}

	/**
	 * Save uploaded file and store the information in file_upload
	 *
	 * @param  file  $file
	 * @param  int  $module_id
	 * @param  string  $ref_code
	 * @param  string  $path
	 * @return  array  $fileinfo
	 */
	public function saveFileUpload($file, $module_id, $ref_code, $path)
	{
		$user = Auth::user();
		$fileinfo = $this->fileHelper->getFileInfo($file);
		$file->move(public_path().$path, $fileinfo['name']);

		file_upload::create([
			'module_id' => $module_id,
			'ref_code' => $ref_code,
			'original_name' => $fileinfo['name'],
			'mimetype' => $fileinfo['mimetype'],
			'size' => $fileinfo['size'],
			'path' => public_path().$path.$fileinfo['name'],
			'created_by' => $user->employee_name
		]);

		return $fileinfo;
	}
}
