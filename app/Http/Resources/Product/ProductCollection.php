<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{

    private function pagination()
    {
        return [
            'total' => $this->total(),
            'count' => $this->count(),
            'on_first_page' => $this->onFirstPage(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'path' =>   $this->path(),
            'previous_page_url' => $this->previousPageUrl(),
            'next_page_url' => $this->nextPageUrl(),
            'total_pages' => $this->lastPage(),
            'has_more_pages' => $this->hasMorePages(),
        ];
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                'response' => $this->collection,
                // 'links' => $this->pagination(),
            ];
    }
}
