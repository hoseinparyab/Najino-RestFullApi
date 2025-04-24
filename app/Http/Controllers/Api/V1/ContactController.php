<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\ApiRequests\Contact\ContactStoreApiRequest;
use App\Services\ContactService;
use App\RestfulApi\Facades\ApiResponse;
use App\Models\Contact;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class ContactController extends Controller
{
    public function __construct(private ContactService $contactService)
    {
    }

    public function index()
    {
        try {
            $result = $this->contactService->getContacts();

            if (!$result->ok) {
                return ApiResponse::withMessage('Failed to fetch contacts')
                    ->withStatus(500)
                    ->build()
                    ->response();
            }

            return ApiResponse::withData($result->data)
                ->build()
                ->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')
                ->withStatus(500)
                ->build()
                ->response();
        }
    }

    public function store(ContactStoreApiRequest $request)
    {
        try {
            $result = $this->contactService->createContact($request->validated());

            if (!$result->ok) {
                return ApiResponse::withMessage('Failed to create contact')
                    ->withStatus(500)
                    ->build()
                    ->response();
            }

            return ApiResponse::withMessage('Contact message received successfully')
                ->withData($this->contactService->getContactResource($result->data))
                ->build()
                ->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')
                ->withStatus(500)
                ->build()
                ->response();
        }
    }

    public function destroy(Contact $contact)
    {
        try {
            $result = $this->contactService->deleteContact($contact);

            if (!$result->ok) {
                return ApiResponse::withMessage('Failed to delete contact')
                    ->withStatus(500)
                    ->build()
                    ->response();
            }

            return ApiResponse::withMessage('Contact deleted successfully')
                ->build()
                ->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')
                ->withStatus(500)
                ->build()
                ->response();
        }
    }
}
