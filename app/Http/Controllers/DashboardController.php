<?php
namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function loadDynamicView(Request $request, $filename = "welcome")
    {
        // You can add validation or security checks here if needed.

        // Construct the view name by adding ".blade.php" to the filename.
        
        $viewName = 'dashboard.' . $filename;

        // Check if the view exists before returning it.
        if (view()->exists($viewName)) {
            return View($viewName);
        } else {
            return view('dashboard.404');
        }
    }
}
