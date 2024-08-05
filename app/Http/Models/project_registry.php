<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class project_registry extends Model
{
	protected $table = 'project_registry';

	protected $fillable = [
		'Project_Code',
		'Project_Short_name',
		'project_type',
		'project_team',
		'Project_Status',
		'Project_Client',
		'MainCon1',
		'Maincon2',
		'Project_Title',
		'Project_Contract_No',
		'tender_id',
		'project_contract_period',
		'Project_PO_No',
		'contract_original_value',
		'contract_vo_value',
		'Tarikh_Pesanan',
		'Project_Commencement_Date',
		'Project_Completion_Date',
		'contract_eot',
		'Project_Close_Date',
		'Project_Liquidity_And_Damages',
		'Project_Defect_Liability_Period',
		'project_client_gm',
		'project_client_kj',
		'Project_Client_Manager',
		'Project_Client_Engineer',
		'Project_Client_Supervisor',
		'project_client_foman',
		'Project_Prepared_by',
		'Project_Date_Prepared',
		'Project_Important_Note',
		'Retention',
		'EntryDate',
		'zone_code',
		'location',
		'latitude',
		'longitude',
		'isdelete',
		'project_gross_profit',
		'client_address_finance',
		'vendor_bulk_private',
		'consultant',
		'awarded_party',
		'po_value',
		'po_no',
		'insurance_project_code',
		'insurance_lost_amount',
		'license_company',
		'project_tender_no',
		'PO_file',
		'client_pic',
		'license_fee_amount',
		'license_fee_percentage',
		'project_code_first_letter',
		'is_physical_work_completed',
	];
	

	public function getFiles()
	{
		return $this->hasMany('App\Http\Models\supplier_invoice_has_document', 'supplier_invoice_id', 'id');
	}
	public function getPO()
	{
		return $this->hasMany('App\Http\Models\supplier_invoice_has_po', 'supplier_invoice_id', 'id');
	}
	public function findCreatedBy()
	{
		return $this->hasOne('App\Http\Models\Member', 'id', 'created_by');
	}
	public function getWO()
	{
		return $this->hasMany('App\Http\Models\workorder_db_one', 'ProjectCode', 'Project_Code');
	}
}
