<?php

namespace App\Services;

use App\Base\ServiceResult;
use App\Base\ServiceWrapper;
use App\Http\Resources\Contact\ContactResource;
use App\Models\Contact;

class ContactService
{
    public function createContact(array $data): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($data) {
            return Contact::create($data);
        });
    }

    public function getContacts(): ServiceResult
    {
        return app(ServiceWrapper::class)(function () {
            return Contact::latest()->paginate(10);
        });
    }

    public function getContactResource(Contact $contact): ContactResource
    {
        return new ContactResource($contact);
    }

    public function deleteContact(Contact $contact): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($contact) {
            $contact->delete();

            return true;
        });
    }
}
