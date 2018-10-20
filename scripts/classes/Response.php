<?php

class Response
{
    protected $error_data = [
        'status' => [
            'code' => 400,
            'code_status' => 'alert-danger',
        ],
        'info' => [
            'message' => 'Unfortunately there was an error with the request',
        ],
    ];

    protected $success_data = [
        'status' => [
            'code' => 200,
            'code_status' => 'alert-success',
        ],
        'info' => [
            'message' => 'Request successfully completed',
        ],
    ];

    protected $warning_data = [
        'status' => [
            'code' => 300,
            'code_status' => 'alert-warning',
        ],
        'info' => [
            'message' => 'Request successfully completed. However there were complications',
        ],
	];

	protected $active_response = '';
	
	public function updateActiveResponse($response_object)
	{
		$this->active_response = $response_object;
	}

    public function editSuccessResponseInfo($arr)
    {
        if (is_array($arr)) {

			// overwrite whole array if custom message key exists 
            if (array_key_exists('message', $arr)) {
                $this->success_data['info'] = $arr;

                return [true, $this->success_data];
            }

			// only merge in new key value pairs, keep default message 
            $this->success_data['info'] = array_merge($this->success_data['info'], $arr);

            return [true, $this->success_data, 'merge'];
        }

        return [false];
    }

    public function editWarningResponseInfo($arr)
    {
        if (is_array($arr)) {
            if (array_key_exists('message', $arr)) {
                $this->warning_data['info'] = $arr;

                return [true, $this->warning_data];
            }

            $this->warning_data['info'] = array_merge($this->warning_data['info'], $arr);

            return [true, $this->warning_data, 'merge'];
        }

        return [false];
    }

    public function editErrorResponseInfo($arr)
    {
        if (is_array($arr)) {
            if (array_key_exists('message', $arr)) {
                $this->error_data['info'] = $arr;

                return [true, $this->error_data];
            }

            $this->error_data['info'] = array_merge($this->error_data['info'], $arr);

            return [true, $this->error_data];
        }

        return [false];
    }

    public function success_response()
    {
        return $this->success_data;
    }

    public function error_response()
    {
        return $this->error_data;
    }

    public function warning_response()
    {
        return $this->warning_data;
	}
	
	public function active_response()
	{
		return $this->active_response;
	}
}

// echo json_encode($render_array);
