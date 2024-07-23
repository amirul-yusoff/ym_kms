<?php

namespace App\Http\Models;

use Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Hash;

class Member extends Authenticatable implements HasMedia
{
    use Notifiable;
    use HasRoles;
    use InteractsWithMedia;
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    	'employee_code',
        'employee_name',
        'firstname',
        'lastname',
        'nickname',
        'password',
        'image',
    	'department',
    	'position',
    	'mbr_email',
        'email',
    	'username',
    	'usergrp',
        'password',
        'status',
        'company_id',
    	'is_active',
    	'isdelete',
    	'created_by',
    	'created_date',
        'last_login'
    ];

    public function findCompanyID()
    {
        return $this->hasOne('App\Http\Models\companies_db_one', 'id', 'company_id');
    }

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
    	'password', 'remember_token'
    ];

    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    
    public function tenders()
    {
        return $this->hasMany('App\Http\Models\Tender', 'RegisteredBy', 'employee_code');
    }
    
    
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('isdelete', 0);
    }

    public function locations()
    {
        return $this->hasMany('App\Http\Models\location', 'employee_code', 'employee_code');
    }

    public function activities()
    {
        return $this->hasMany('App\Http\Models\member_activity');
    }

    public function isOnline()
    {
        return Cache::has('user-online-'.$this->id);
    }

    public function project_view()
    {
        return $this->hasOne('App\Http\Models\special_permission', 'employee_code', 'employee_code')->where('module_id', 1)->where('permission', 1)->where('isdelete', 0);
    }

    public function request_view()
    {
        return $this->hasOne('App\Http\Models\special_permission', 'employee_code', 'employee_code')->where('module_id', 2)->where('permission', 1)->where('isdelete', 0);
    }

    public function dashboard_view()
    {
        return $this->hasOne('App\Http\Models\special_permission', 'employee_code', 'employee_code')->where('module_id', 3)->where('permission', 1)->where('isdelete', 0);
    }

    public function project_file_upload_view()
    {
        return $this->hasOne('App\Http\Models\special_permission', 'employee_code', 'employee_code')->where('module_id', 4)->where('permission', 1)->where('isdelete', 0);
    }


    public function daytimelogin()
    {
        return $this->hasMany('App\Http\Models\location', 'employee_code', 'employee_code');
    }
    
    public function nighttimelogin()
    {
        return $this->hasMany('App\Http\Models\location', 'employee_code', 'employee_code');
    }
}
