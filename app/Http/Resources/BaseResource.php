<?php

namespace App\Http\Resources;

use Helper\ResponseService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array = parent::toArray($request);
        if (!empty($array['logo'])) {
            $array['logo'] = $this->logo_url;
        }
        if (!empty($array['image'])) {
            $array['image'] = $this->image_url;
        }
        if (!empty($array['created_at'])) {
            $array['created_at'] = $this->created_at->getTimestamp();
        }
        if (!empty($array['updated_at'])) {
            $array['updated_at'] = $this->updated_at->getTimestamp();
        }
        return $array;
    }

    /**
     * @param mixed $resource
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        $result = parent::collection($resource);
        if ($resource instanceof LengthAwarePaginator) {
            return ResponseService::responsePaginate($result, $resource);
        }
        return $result;
    }
}
