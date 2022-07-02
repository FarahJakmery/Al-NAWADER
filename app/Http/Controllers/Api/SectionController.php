<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\SaveImageTrait;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    use ApiResponseTrait, SaveImageTrait;

    public function allSections()
    {
        $sections = Section::translated()->get();
        if ((count($sections) == null)) {
            return $this->apiResponse($sections, 'There are not any Sections', 401);
        }
        return $this->apiResponse($sections, 'These Are All Sections', 200);
    }

    public function showSection($section_id)
    {
        $section = Section::where('id', '=', $section_id)->with(['categories', 'advertisements'])->first();
        if ($section) {
            return $this->apiResponse($section, 'This Is The Required Section', 200);
        }
        return $this->apiResponse($section, 'The Section Not Found', 401);
    }
}
