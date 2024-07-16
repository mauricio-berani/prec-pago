<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $service
    ) {}

    public function create(TransactionRequest $request): Response
    {
        $data = $request->validated();
        $response = $this->service->create($data['amount'], $data['timestamp']);

        if ($response === TransactionStatus::EXPIRED->value) {
            return $this->handleNoContentResponse();
        }

        if ($response === TransactionStatus::ERROR->value) {
            return $this->handleInternalserverErrorResponse();
        }

        return $this->handleCreatedResponse();
    }

    public function delete()
    {
        $this->service->delete();

        return $this->handleNoContentResponse();
    }
}
