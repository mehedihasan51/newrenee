<?php

namespace App\Http\Controllers\Web\Ajax;

use App\Helpers\Helper;
use App\Models\Commitment;
use App\Models\Subcategory;
use App\Http\Controllers\Controller;

class CommitmentController extends Controller
{
    public function getCommitments()
    {
        $commitments = Commitment::select('id', 'title')->get();
    
        return response()->json($commitments);
    }
}