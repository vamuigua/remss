<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notice;

class NoticesController extends Controller
{
    // Notices index
    public function notices(Request $request){
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $notices = Notice::where('subject', 'LIKE', "%$keyword%")
                ->orWhere('message', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $notices = Notice::latest()->paginate($perPage);
        }

        return view ('tenant.notices.index', compact('notices'));   
    }

    // Notices Show 
    public function noticesShow($id){
        $notice = Notice::findOrFail($id);
        return view ('tenant.notices.show', compact('notice'));   
    }
}
