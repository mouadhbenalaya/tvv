@php
    $phpTag = "<?php";
@endphp

{!! $phpTag !!}

namespace {{ $controllerNamespace }};

use App\Http\Controllers\Controller;
use App\Http\Resources\{{ $entityName }}Resource;
use {{ $entityNamespace }}\{{ $entityName }};
use Illuminate\Http\Resources\Json\ResourceCollection;

class RetrieveCollection{{ $entityName }} extends Controller
{
    /**
     * @OA\Get(
     *     tags={"{{ $entityName }}s"},
     *     path="{{ $apiPath }}",
     *     operationId="get{{$entityName}}s",
     *     summary="Get list of {{ strtolower($entityName) }}s",
@if ($isAuth)
     *     security={ {"sanctum": {} } },
@endif
     *     @OA\Response(
     *          response="200",
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="{{ strtolower($entityName) }}", type="object", ref="#/components/schemas/{{ $entityName }}Resource")
     *          ),
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
@if ($isAuth)
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *       ),
@endif
     * )
     */
    public function __invoke(): ResourceCollection
    {
        return {{ $entityName }}Resource::collection({{ $entityName }}::all());
    }
}
