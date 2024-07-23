<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class supplier_invoice_has_document extends Model
{
    protected $table = 'supplier_invoice_has_document';
    protected $primaryKey = 'id';
    protected $fillable = [
        'supplier_invoice_id',
        'filename',
        'mimetype',
        'extension',
        'size',
        'path',
        'upload_by',
        'created_at',
        'updated_at',
        'is_deleted',
        'hash',
        'file_type',
        'url',
        'document_type'
        ];

}
