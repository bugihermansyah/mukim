<?php

namespace App\Models;

use Glorand\Model\Settings\Traits\HasSettingsField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory, HasSettingsField;

    public $settingsFieldName = 'company';

    protected $fillable = [
        'company'
    ];
}
