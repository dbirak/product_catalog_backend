<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => new CategoryResource(Category::findOrFail($this->category_id)),
            'user' => new UserResource(User::findOrFail($this->user_id)),
            'image_name' => $this->image_name,
            'pdf_name' => $this->pdf_name,
            'code_qr' => $this->code_qr,
        ];
    }
}
