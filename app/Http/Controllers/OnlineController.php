<?php

namespace App\Http\Controllers;

use App\Events\OnlineEvent;
use App\Models\User;
use Illuminate\Http\Request;

class OnlineController extends Controller
{
    public function __invoke($id){
        User::where('id','=',$id)->update(['status' => 1]);

        event(new OnlineEvent(User::find($id)));
    }
}
