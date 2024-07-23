<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// Quantity alerted field is for us to consider which JMS has been included in alerting for LOC claim checking.

class CreateJointMeasurementSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joint_measurement_sheets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('workorder_id')->references('ID')->on('workorder');
            $table->unsignedDecimal('quantity', 8, 2);
            $table->string('signed_wo_document', 250)->nullable();
            $table->string('jms_document', 250)->nullable();
            $table->string('sld_document', 250)->nullable();
            $table->string('site_photo_document_1', 250)->nullable();
            $table->string('site_photo_document_2', 250)->nullable();
            $table->string('site_photo_document_3', 250)->nullable();
            $table->string('site_photo_document_4', 250)->nullable();
            $table->boolean('reviewed_by_pe')->nullable();
            $table->dateTime('pe_action_date')->nullable();
            $table->string('status', 20)->nullable()->default('New');
            $table->boolean('invoiced')->default(0);
            $table->boolean('paid')->default(0);
            $table->boolean('quantity_alerted')->default(0);
            $table->bigInteger('company_id')->references('id')->on('companies');
            $table->bigInteger('created_by')->references('id')->on('members');
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
        Schema::dropIfExists('joint_measurement_sheets');
    }
}
