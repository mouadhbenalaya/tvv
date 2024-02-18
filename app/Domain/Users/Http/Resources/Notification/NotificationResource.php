<?php

namespace App\Domain\Users\Http\Resources\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class NotificationResource.
 *
 * @property int $id
 * @property mixed $data
 * @property \DateTime|null $read_at
 * @property \DateTime $created_at
 */
class NotificationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'data'      => $this->data,
            'readAt'    => !is_null($this->read_at)
                ? ($this->read_at->format('Y-m-d\TH:i:s'))
                : null,
            'createdAt' => $this->created_at->format('Y-m-d\TH:i:s'),
        ];
    }
}
