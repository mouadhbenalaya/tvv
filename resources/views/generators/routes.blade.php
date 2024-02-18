@php
$route = $entityData['isAuth']
    ? "Route::middleware('auth:sanctum')->"
    : "Route::";

$entityName = $entityData['entityName'];
$namespace = $entityData['controllerNamespace'];
@endphp

@if (array_key_exists('C', $templates))
{!! $route !!}post('/v1/{{ strtolower($entityName) }}s', \{{ $namespace }}\Create{{ $entityName }}::class);
@endif
@if(array_key_exists('L', $templates))
{!! $route !!}get('/v1/{{ strtolower($entityName) }}s', \{{ $namespace }}\RetrieveCollection{{ $entityName  }}::class);
@endif
@if(array_key_exists('R', $templates))
{!! $route !!}get('/v1/{{ strtolower($entityName) }}s/{{'{'}}{{ strtolower($entityName) }}{{'}'}}', \{{ $namespace }}\Retrieve{{ $entityName  }}::class);
@endif
@if(array_key_exists('U', $templates))
{!! $route !!}put('/v1/{{ strtolower($entityName) }}s/{{'{'}}{{ strtolower($entityName) }}{{'}'}}', \{{ $namespace }}\Update{{ $entityName  }}::class);
@endif
@if(array_key_exists('D', $templates))
{!! $route !!}delete('/v1/{{ strtolower($entityName) }}s/{{'{'}}{{ strtolower($entityName) }}{{'}'}}', \{{ $namespace }}\Delete{{ $entityName }}::class);
@endif
