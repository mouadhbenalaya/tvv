@php
    $phpTag = "<?php";
@endphp

{!! $phpTag !!}

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class {{ $entityName }}Resource
 * @OA\Schema(
 * )
 */
class {{ $entityName }}Resource extends JsonResource
{
    /**
     * @OA\Property(format="int64", default=1, property="id")
@foreach ($properties as $key => $property)
@php
    $format = $property['swagger']['format'];
    $value = $property['swagger']['value'];

    if ($property['swagger']['isString']) {
        $value = '"' . $value . '"';
    }
@endphp
     * @OA\Property(format="{{ $format }}", default={!! $value !!}, property="{{ $key }}")
@endforeach
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
@foreach ($properties as $key => $property)
            '{{ $key }}' => $this->{{ $key }},
@endforeach
        ];
    }
}
