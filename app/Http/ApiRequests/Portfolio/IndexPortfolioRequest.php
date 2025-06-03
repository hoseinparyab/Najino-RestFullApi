<?php

namespace App\Http\ApiRequests\Portfolio;

use Illuminate\Support\Facades\Gate;
use App\RestfulApi\ApiFormRequest;

class IndexPortfolioRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('portfolio_read');
    }

    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }
}
