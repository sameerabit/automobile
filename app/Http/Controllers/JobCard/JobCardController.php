<?php

namespace App\Http\Controllers\JobCard;

use App\Http\Controllers\Controller;


class JobCardController extends Controller
{

    public function create()
    {
        return view('job_card.create');
    }
    

}