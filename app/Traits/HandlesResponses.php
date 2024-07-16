<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait HandlesResponses
{
    protected function handleResponse(int $statusCode)
    {
        return response()->noContent($statusCode);
    }

    protected function handleCreatedResponse()
    {
        return $this->handleResponse(Response::HTTP_CREATED);
    }

    protected function handleNoContentResponse()
    {
        return $this->handleResponse(Response::HTTP_NO_CONTENT);
    }

    protected function handleUnprocessableEntityResponse()
    {
        return $this->handleResponse(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function handleBadRequestResponse()
    {
        return $this->handleResponse(Response::HTTP_BAD_REQUEST);
    }

    protected function handleInternalServerErrorResponse()
    {
        return $this->handleResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
