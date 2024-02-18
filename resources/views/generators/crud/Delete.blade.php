@php
    $phpTag = "<?php";
@endphp

{!! $phpTag !!}

namespace {{ $controllerNamespace }};

use App\Http\Controllers\Controller;
use {{ $entityNamespace }}\{{ $entityName }};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Delete{{ $entityName }} extends Controller
{
    /**
     * @OA\Delete(
     *     tags={"{{ $entityName }}s"},
     *     path="{{ $apiPath }}/{{'{'}}{{ strtolower($entityName) }}{{'}'}}",
     *     operationId="delete{{ $entityName }}",
     *     summary="Delete {{ strtolower($entityName) }}",
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
     *          response="204",
     *          description="Deleted",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="{{ $entityName }} deleted."),
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
        ${{ strtolower($entityName) }}->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
