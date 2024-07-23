<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditorInvoiceJointMeasurementSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditor_invoice_joint_measurement_sheet', function (Blueprint $table) {
            $table->unsignedBigInteger('creditor_invoice_id');
            $table->unsignedBigInteger('joint_measurement_sheet_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('creditor_invoice_joint_measurement_sheet');
    }
}
