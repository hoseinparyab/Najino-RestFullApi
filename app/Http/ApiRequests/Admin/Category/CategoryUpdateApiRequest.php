<?php
namespace App\Http\ApiRequests\Admin\Category;

use App\Models\Category;
use App\RestfulApi\ApiFormRequest;
use Illuminate\Support\Facades\Gate;
class CategoryUpdateApiRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('category_update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Category::rules();
    }
}
