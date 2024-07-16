<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait HandlesResponses
{
    protected function handleCreatedResponse()
    {
        return response()->noContent(Response::HTTP_CREATED);
    }

    protected function handleNoContentResponse()
    {
        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    protected function handleUnprocessableEntityResponse()
    {
        return response()->noContent(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function handleBadRequestResponse()
    {
        return response()->noContent(Response::HTTP_BAD_REQUEST);
    }

    protected function handleInternalserverErrorResponse()
    {
        return response()->noContent(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
