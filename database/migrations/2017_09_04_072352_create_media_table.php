<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * @var string
     */
    protected $mediasTable;

    /**
     * CreateCustomerTable constructor.
     */
    public function __construct()
    {
        $this->mediasTable = Config::get('media.medias_table');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing medias
        Schema::create($this->mediasTable, function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename');
            $table->unsignedInteger('size');
            $table->string('mime_type');
            $table->string('disk');
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
        Schema::dropIfExists($this->mediasTable);
    }
}