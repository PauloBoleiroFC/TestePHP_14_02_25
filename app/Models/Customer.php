<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    public $with = ["requests"];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_date',
        'address',
        'neighborhood',
        'complement',
        'district',
        'zip_code',
        'registered_at'
    ];

    /**
     * @var string[]
     */
    protected $dates = ['deleted_at', 'registered_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function requests()
    {
        return $this->BelongsToMany (Request::class);
    }
}
