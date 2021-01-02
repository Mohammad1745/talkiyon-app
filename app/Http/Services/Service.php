<?php


namespace App\Http\Services;


class Service
{
    /**
     * @var array
     */
    private $response = [
        'success' => null,
        'message' => '',
        'data' => null
    ];
    /**
     * @var string
     */
    private $errorMessage = 'Something went wrong! ';

    /**
     * @param null $data
     * @return $this
     */
    protected function response($data=null): Service
    {
        $this->response['data'] = $data;

        return $this;
    }

    /**
     * @param null $message
     * @return array
     */
    protected function success($message=null): array
    {
        $this->response['success'] = true;
        $this->response['message'] = $message ?
            __($message) :
            __('Done');

        return $this->response;
    }

    /**
     * @param null $message
     * @return array
     */
    protected function error($message=null): array
    {
        $this->response['success'] = false;
        $this->response['message'] = $message ?
            __($message) :
            __($this->errorMessage);

        return $this->response;
    }
}
