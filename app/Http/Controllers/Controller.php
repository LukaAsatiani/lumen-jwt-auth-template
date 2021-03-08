<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Traits\CustomResponse;

class Controller extends BaseController {
    use CustomResponse;    
}
