<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class NotifyController extends Controller
{
    function index() {
        return view('admin.notify.index');
    }
}
