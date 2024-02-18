@php
    $phpTag = "<?php";
@endphp

{!! $phpTag !!}

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class {{ $entityName }} extends Model
{
    use HasFactory;

    protected $fillable = [
@foreach ($properties as $key => $property)
        '{{ $key }}',
@endforeach
    ];
}
