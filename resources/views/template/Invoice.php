<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	/**
	 * PREREQUISITES
	 * Contract No is retrieved from Project Registry
	 * 
	 * Description of module
	 * Invoice Module
	 * 
	 * Data structure explanations
	 * id
	 * project_id
	 * invoice_no
	 * po_no
	 * date
	 * remarks
	 * is_final_claim
	 * claim_no
	 * payment_term
	 * gross_amount
	 * retention_amount
	 * net_amount
	 * paid_amount
	 * toc_claimed
	 * cc_claimed
	 * is_paid
	 * issued_by
	 * created_at
	 * updated_at
	 * is_deleted
	 * 
	 * 
	 * Features
	 * List of Invoices in index, fields to display 
	 *  
	 * Alerting and Reporting
	 * 
	 * 
	 *  */ 

	protected $dates = ['date', 'created_at', 'updated_at'];

    protected $fillable = [
		'project_id',
		'invoice_no',
		'payment_term',
    	'po_no',
    	'date',
    	'remarks',
    	'is_final_claim',
    	'claim_no',
    	'gross_amount',
    	'retention_amount',
		'net_amount',
		'paid_amount',
		'retention_claimed',
    	'is_paid',
    	'issued_by',
    	'created_at',
    	'updated_at',
    	'is_deleted'
	];
	

	public function clientPayments()
    {
        return $this->belongsToMany('App\Http\Models\ClientPayment');
	}

	public function letterOfClaims()
    {
        return $this->belongsToMany('App\Http\Models\LetterOfClaim', 'invoice_id', 'letter_of_claim_id');
	}

	public function project()
    {
        return $this->belongsTo('App\Http\Models\project_registry', 'project_id', 'Project_ID');
	}

	public function accountEmployee()
    {
        return $this->belongsTo('App\Http\Models\Member', 'issued_by');
	}

	public static function sumOfInvoiceOverdue() {
		return Invoice::selectRaw('SUM(net_amount - paid_amount) as overdueAmount')->whereRaw('date_add(`date`, INTERVAL `payment_term` DAY) < now() and is_paid = 0')->first();
	}

	public static function invoicesOverDue() {
		return Invoice::with('project')->selectRaw('id, (net_amount - paid_amount) as overdueAmount, paid_amount, project_id, invoice_no, date, date_add(`date`, INTERVAL `payment_term` DAY) as dueDate')->whereRaw('date_add(`date`, INTERVAL `payment_term` DAY) < now() and is_paid = 0')->get();
	}

// uncalled function
	public function getInvoiceDetailAttribute() {
    return 'invoice no: ' . $this->invoice_no . ' po no: ' . $this->po_no;
  }
	public function scopeNotPaid($query) {
        return $query->with('project')->where('is_paid', '0')->orderBy('date', 'desc')->get();
	}
}
