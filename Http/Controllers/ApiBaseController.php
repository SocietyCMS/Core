<?php

namespace Modules\Core\Http\Controllers;

use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

class ApiBaseController extends Controller
{
    use Helpers;

    public function __construct()
    {
    }

    /**
     * return success message.
     *
     * @param $message
     *
     * @return mixed
     */
    protected function success($message)
    {
        return $this->response->array(['success' => true, 'message' => $message]);
    }

    /**
     * resource successfully created.
     *
     * @return mixed
     */
    protected function successCreated()
    {
        return $this->success('Created')->statusCode(201);
    }

    /**
     * resource successfully updated.
     *
     * @return mixed
     */
    protected function successUpdated()
    {
        return $this->success('Updated')->statusCode(200);
    }

    /**
     * resource successfully updated.
     *
     * @return mixed
     */
    protected function successDeleted()
    {
        return $this->success('Deleted')->statusCode(200);
    }

    /**
     * resource successfully updated.
     *
     * @return mixed
     */
    protected function successRestored()
    {
        return $this->success('Restored')->statusCode(200);
    }
}
