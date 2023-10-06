<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomAgentDashboardController extends Controller
{
    public function loadDynamicView(Request $request, $filename = "welcome")
    {
        // You can add validation or security checks here if needed.

        // Construct the view name by adding ".blade.php" to the filename.

        $viewName = 'agent.' . $filename;

        // Check if the view exists before returning it.
        if (view()->exists($viewName)) {
            $data = $this->processRequest($filename);
            return View($viewName, $data);
        } else {
            return view('dashboard.404');
        }
    }

    private function processRequest($page)
    {
        // Your private method logic here
        if ($page === "users") {
            $users = User::all();
            return compact('users');
        } else {
            return [];
        }
    }
}