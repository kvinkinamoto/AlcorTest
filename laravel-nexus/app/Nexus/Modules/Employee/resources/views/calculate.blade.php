@extends('nexus::' . config('nexus.template') . '.layouts.adminpanel')

@section('contentPageCaption')
    Calculate payroll — {{ $employee->getAttribute('name') }}
@endsection

@section('mainContent')
    <style>
        .calc-card { max-width: 32rem; padding: 1.25rem; border: 1px solid rgba(128,128,128,.3); border-radius: 1rem; }
        .calc-card input { padding: .5rem .75rem; border: 1px solid rgba(128,128,128,.4); border-radius: .5rem; background: #fff; color: #1d2939; }
        html.dark .calc-card input { background: #101828; color: #e5e7eb; }
        .calc-card button, .calc-card a.btn { padding: .5rem 1rem; border-radius: .5rem; border: 1px solid rgba(128,128,128,.4); cursor: pointer; background: #465fff; color: #fff; text-decoration: none; display: inline-block; }
        .calc-card a.btn { background: transparent; color: inherit; }
        .calc-card dl { display: grid; grid-template-columns: auto 1fr; gap: .25rem 1rem; margin: 0 0 1rem; }
        .calc-card dt { opacity: .6; }
    </style>
    <div class="calc-card">
        <dl>
            <dt>Base salary</dt><dd>{{ $employee->money('base_salary')->format() }}</dd>
            <dt>Benefits deduction</dt><dd>−{{ $employee->money('benefits_deduction')->format() }}</dd>
            <dt>Bonus</dt><dd>+{{ $employee->money('bonus')->format() }}</dd>
            <dt>Calculated salary</dt><dd><strong>{{ app(\App\Payroll\SalarySource::class)->calculate($employee, $period)->format() }}</strong></dd>
        </dl>
        <p style="opacity:.7;font-size:.85rem">If the period already has a line it is recalculated — unless the line has manual adjustments, in which case the result is only logged in the audit.</p>
        <form method="post" action="{{ route('nexus.module.action', ['module' => $module->name, 'action' => 'calculate', 'id' => $employee->id]) }}">
            @csrf
            <label>Period <input name="period" value="{{ old('period', $period) }}" pattern="\d{4}-\d{2}" size="8" required></label>
            <button type="submit">Calculate</button>
            <a class="btn" href="{{ route('nexus.module.action', ['module' => $module->name, 'action' => 'index']) }}">Cancel</a>
        </form>
    </div>
@endsection
