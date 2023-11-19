<?php

use App\Models\Building;
use App\Models\Rtrw;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('building_rtrw', function (Blueprint $table) {
            $table->foreignIdFor(Building::class);
            $table->foreignIdFor(Rtrw::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('building_rtrw');
    }
};
