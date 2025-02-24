<?php
namespace App\Http\Requests\Organization;

use App\Http\Requests\Request;

class ListOrganizationRequest extends Request
{
    protected function addRules(): array
    {
        return [
            'order_by' => 'required_with:order|string|in:id,name,facility_limit',
            'order' => 'required_with:order_by|string|in:ASC,DESC,asc,desc',
            'page' => 'integer',
        ];
    }
}
