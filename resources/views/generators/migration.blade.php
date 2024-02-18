@php
    $phpTag = "<?php";
@endphp

{!! $phpTag !!}

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{ strtolower($entityName) }}s', function (Blueprint $table) {
            $table->id();
    @foreach ($properties as $key => $property)
    @php
        $option = '';
        if ($property['nullable']) {
            $option = "->nullable()";
        }
        if ($property['unique']) {
            $option = "->unique()";
        }
    @endphp
    $table->{{$property['type']}}('{{ $key }}'){!! $option !!};
    @endforeach
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('{{ strtolower($entityName) }}s');
    }
};
