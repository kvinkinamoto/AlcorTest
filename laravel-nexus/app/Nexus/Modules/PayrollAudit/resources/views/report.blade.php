@extends('nexus::' . config('nexus.template') . '.layouts.adminpanel')

@section('contentPageCaption')
    Payroll audit
@endsection

@section('mainContent')
    <style>
        .audit-filters { display: flex; flex-wrap: wrap; gap: .75rem; align-items: end; margin-bottom: 1rem; }
        .audit-filters label { display: flex; flex-direction: column; font-size: .8rem; opacity: .85; gap: .2rem; }
        .audit-filters select, .audit-filters input { padding: .4rem .6rem; border: 1px solid rgba(128,128,128,.4); border-radius: .5rem; background: #fff; color: #1d2939; color-scheme: light; }
        html.dark .audit-filters select, html.dark .audit-filters input { background: #101828; color: #e5e7eb; color-scheme: dark; }
        .audit-filters select option { background: #fff; color: #1d2939; }
        html.dark .audit-filters select option { background: #101828; color: #e5e7eb; }
        .audit-btn { padding: .45rem 1rem; border-radius: .5rem; border: 1px solid rgba(128,128,128,.4); background: #465fff; color: #fff; text-decoration: none; cursor: pointer; }
        .audit-btn.alt { background: transparent; color: inherit; }
        .audit-card { border: 1px solid rgba(128,128,128,.3); border-radius: 1rem; padding: 1rem; margin-bottom: 1rem; overflow-x: auto; }
        .audit-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
        .audit-table th, .audit-table td { padding: .4rem .6rem; text-align: left; border-bottom: 1px solid rgba(128,128,128,.25); vertical-align: top; }
        .audit-table .n { text-align: right; white-space: nowrap; font-variant-numeric: tabular-nums; }
        .audit-table .neg { color: #dc2626; } .audit-table .pos { color: #16a34a; } .audit-table .muted { opacity: .6; }
        .audit-badge { font-size: .7rem; padding: .1rem .5rem; border-radius: 99px; background: #fef3c7; color: #92400e; margin-left: .5rem; }
    </style>

    <form method="get" class="audit-filters">
        <label>Employee
            <select name="employee" onchange="this.form.submit()">
                @foreach ($employees as $e)
                    <option value="{{ $e->id }}" @selected($employee && $employee->id === $e->id)>{{ $e->name }}</option>
                @endforeach
            </select>
        </label>
        <label>Period
            <select name="period">
                <option value="">All periods</option>
                @foreach ($periods as $p)
                    <option value="{{ $p }}" @selected(($filters['period'] ?? '') === $p)>{{ $p }}</option>
                @endforeach
            </select>
        </label>
        <label>From <input type="date" name="from" value="{{ $filters['from'] ?? '' }}"></label>
        <label>To <input type="date" name="to" value="{{ $filters['to'] ?? '' }}"></label>
        <button class="audit-btn" type="submit">Filter</button>
        <a class="audit-btn alt" href="{{ route('nexus.module.action', ['module' => $module->name, 'action' => 'index', 'employee' => $employee?->id]) }}">Full history</a>
        @if ($employee)
            <a class="audit-btn alt" href="{{ route('nexus.module.action', ['module' => $module->name, 'action' => 'export'] + $filters) }}">Export CSV</a>
        @endif
    </form>
    <p style="font-size:.8rem;opacity:.7;margin-top:-.5rem">Leave both dates empty for the entire history. With a date window the running totals start from an opening balance.</p>

    @if (! $report)
        <div class="audit-card">No employees yet.</div>
    @elseif ($report->sections === [])
        <div class="audit-card">No entries for this selection.</div>
    @else
        @foreach ($report->sections as $section)
            <div class="audit-card">
                <h3 style="margin:0 0 .5rem;font-weight:600">
                    {{ $report->employeeName }} — {{ $section->period }}
                    @if ($section->frozen)<span class="audit-badge">frozen by manual adjustments</span>@endif
                </h3>
                <table class="audit-table">
                    <thead>
                    <tr><th>Date</th><th>Entry</th><th class="n">Amount</th><th class="n">Running total</th><th>By</th><th>Comment</th></tr>
                    </thead>
                    <tbody>
                    @if ($section->opening)
                        <tr class="muted"><td></td><td>Opening balance</td><td></td><td class="n">{{ $section->opening->format() }}</td><td></td><td></td></tr>
                    @endif
                    @foreach ($section->entries as $e)
                        <tr @class(['muted' => $e->type->value === 'system_ignored'])>
                            <td>{{ $e->at->format('Y-m-d H:i') }}</td>
                            <td>{{ $e->label() }}</td>
                            <td @class(['n', 'neg' => $e->adjustmentNo && $e->amount->cents < 0, 'pos' => $e->adjustmentNo && $e->amount->cents > 0])>{{ $e->amount->format($e->adjustmentNo !== null) }}</td>
                            <td class="n">{{ $e->runningTotal->format() }}</td>
                            <td>{{ $e->actor ?? 'system' }}</td>
                            <td>{{ $e->comment }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr><th colspan="3">Current value (system value {{ $section->systemValue->format() }})</th><th class="n">{{ $section->currentValue->format() }}</th><th colspan="2"></th></tr>
                    </tfoot>
                </table>
            </div>
        @endforeach
    @endif
@endsection
