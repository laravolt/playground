<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravolt\Suitable\AutoFilter;
use Laravolt\Suitable\AutoSort;

class ContactForm extends Model
{
    use AutoFilter;
    use AutoSort;

    protected $guarded = [];
}
