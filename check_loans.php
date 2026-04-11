<?php
print_r(\App\Models\Loan::latest()->take(15)->get(['id', 'status', 'fine', 'due_date', 'notes'])->toArray());
