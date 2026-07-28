<?php
namespace App\Http\Controllers\Masyarakat;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() {
        return view("masyarakat.dashboard");
    }
}