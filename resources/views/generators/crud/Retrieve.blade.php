@php
    $phpTag = "<?php";
@endphp

{!! $phpTag !!}

namespace {{ $controllerNamespace }};

use App\Http\Controllers\Controller;
use App\Http\Resources\{{ $entityName }}Resource;
use {{ $entityNamespace }}\{{ $entityName }};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Retrieve{{ $entityName }} extends Controller
{
    /**
     * @OA\Get(
     *     tags={"{{ $entityName }}s"},
     *     path="{{ $apiPath }}/{{'{'}}{{ strtolower($entityName) }}{{'}'}}",
     *     operationId="get{{ $entityName }}",
     *     summary="Get {{ strtolower($entityName) }}",
@if ($isAuth)
     *     security={ {"sanctum": {} } },
@endif
     *     @OA\Parameter(
     *          name="{{ strtolower($entityName) }}",
     *          in="path",
     *          description="{{ $entityName }} id",
     *          required=true,
     *          example=1
     *      ),
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
     *     @OA\Response(
     *          response=404,
     *          description="Not found",
     *       ),
     * )
     */
    public function __invoke({{ $entityName }} ${{ strtolower($entityName) }}): JsonResponse
    {
        return response()->json(new {{ $entityName }}Resource(${{ strtolower($entityName) }}), Response::HTTP_OK);
    }
}
