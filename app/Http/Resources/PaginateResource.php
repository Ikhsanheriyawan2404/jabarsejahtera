<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    public $status, $message, $total, $next;

    public function __construct($status, $message, $resource = [], $total, $next)
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
        $this->total = $total;
        $this->next = $next;
    }

    public function toArray($request)
    {
        return [
            'status'   => $this->status,
            'message'  => $this->message,
            'total'    => $this->total,
            'next'     => $this->next,
            'data'     => $this->resource,
        ];
    }
}
