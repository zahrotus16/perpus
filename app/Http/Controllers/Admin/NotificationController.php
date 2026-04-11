<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $overdueCount = Loan::where('due_date', '<', now())
            ->where('status', 'borrowed')
            ->count();

        $activeLoansCount = Loan::where('status', 'borrowed')->count();

        $recentLoans = Loan::with(['user', 'book'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn($loan) => [
                'id'         => $loan->id,
                'user_name'  => $loan->user->name,
                'book_title' => \Illuminate\Support\Str::limit($loan->book->title, 30),
                'status'     => $loan->status,
                'time'       => $loan->created_at->diffForHumans(),
                'url'        => route('admin.loans.show', $loan->id),
                'is_overdue' => $loan->due_date < now() && $loan->status === 'borrowed'
            ]);

        return response()->json([
            'overdue_count'      => $overdueCount,
            'active_loans_count' => $activeLoansCount,
            'notifications'      => $recentLoans,
            'total_unread'       => $overdueCount // For now simple logic
        ]);
    }
}
