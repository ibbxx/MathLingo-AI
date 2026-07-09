<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    /**
     * Display the student dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        $user = Auth::user();
        $data = $this->dashboardService->getStudentData($user);

        return view('dashboard', array_merge(['user' => $user], $data));
    }
}
