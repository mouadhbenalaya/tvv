@php
    $phpTag = "<?php";

    $required = implode('","', array_keys($properties));
@endphp

{!! $phpTag !!}

namespace {{ $controllerNamespace }};

use App\Http\Controllers\Controller;
use App\Http\Requests\{{ $entityName }}Request;
use App\Http\Resources\{{ $entityName }}Resource;
use {{ $entityNamespace }}\{{ $entityName }};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Create{{ $entityName }} extends Controller
{
    /**
     * @OA\Post(
     *     tags={"{{ $entityName }}s"},
     *     path="{{ $apiPath }}",
     *     operationId="create{{ $entityName }}",
     *     summary="Create {{ strtolower($entityName) }}",
@if ($isAuth)
     *     security={ {"sanctum": {} } },
@endif
     *     @OA\RequestBody(
     *          required=true,
     *          description="Create {{ strtolower($entityName) }}",
     *          @OA\JsonContent(
     *              required={"{!! $required !!}"},
@foreach ($properties as $key => $property)
@php
    $format = $property['swagger']['format'];
    $value = $property['swagger']['value'];

    if ($property['swagger']['isString']) {
        $value = '"' . $value . '"';
    }
@endphp
     *              @OA\Property(property="{{ $key }}", type="{{ $format }}", example={!! $value !!}),
@endforeach
     *          ),
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="{{ $entityName }} created successfully",
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
     *          response=422,
     *          description="Validation failed"
     *      )
     * )
     */
    public function __invoke({{ $entityName }}Request $request): JsonResponse
    {
        ${{ strtolower($entityName) }} = {{ $entityName }}::create($request->all());

        return response()->json(new {{ $entityName }}Resource(${{ strtolower($entityName) }}), Response::HTTP_CREATED);
    }
}
