<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_group extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'm_groups';

    /**
     * @var string[]
     */
    protected $fillable = [
        'gname',
        'ystart',
        'yend',
    ];
}
