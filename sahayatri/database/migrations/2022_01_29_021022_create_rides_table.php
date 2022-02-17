<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->constrained()->onDelete('cascade');
            $table->string('initial_lat');
            $table->string('initial_lng');
            $table->string('destination_lat');
            $table->string('destination_lng');
            $table->enum('ride_type', ['parcel', 'intercity']);
            $table->string('scheduled_date')->nullable();
            $table->string('scheduled_time')->nullable();
            $table->string('total_fare');
            $table->enum('status', ['pending', 'cancelled', 'completed']);
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
        Schema::dropIfExists('rides');
    }
}
