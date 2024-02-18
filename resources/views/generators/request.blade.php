@php
    $phpTag = "<?php";
@endphp

{!! $phpTag !!}

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class {{ $entityName }}Request extends FormRequest
{
    public function rules()
    {
        return match ($this->getMethod()) {
            'POST' => [
@foreach($properties as $key => $property)
    @php
        $uniqueRule = '';
        if ($property['unique']) {
            $uniqueRule = ", Rule::unique('" . strtolower($entityName) . "s', '" . $key . "')->ignore(" . '$this' . "->" . strtolower($entityName) . ")";
        }
        $type = $property['type'];
        if ($property['type'] === 'text') {
            $type = 'string';
        }
    @endphp
            '{{ $key }}' => ['required', '{{ $type }}'{!! $uniqueRule !!}],
@endforeach
            ],
            'PUT', 'PATCH' => [
@foreach($properties as $key => $property)
    @php
        $uniqueRule = '';
        if ($property['unique']) {
            $uniqueRule = ", Rule::unique('" . strtolower($entityName) . "s', '" . $key . "')->ignore(" . '$this' . "->" . strtolower($entityName) . ")";
        }
        $type = $property['type'];
        if ($property['type'] === 'text') {
            $type = 'string';
        }
    @endphp
            '{{ $key }}' => ['{{ $type }}'{!! $uniqueRule !!}],
@endforeach
            ],
            default => [],
        };
    }
}
