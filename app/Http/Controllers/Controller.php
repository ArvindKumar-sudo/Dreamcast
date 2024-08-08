<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function returnResponse($status = 200, $statusText = true, $message = "Good", $data = [], $validation_error = null)
	{
		$data['message'] = $message;
		$data['status'] = $statusText;
		$data['code'] = $status;
		if (!is_null($validation_error)) {
			$data['data'] = $validation_error;
		}
		return response()->json($data, $status);
	}
}
