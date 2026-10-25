<x-filament-panels::page>
    <style>
        .audit-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
        .audit-table th, .audit-table td { padding: .4rem .6rem; text-align: left; border-bottom: 1px solid rgba(128,128,128,.25); vertical-align: top; }
        .audit-table .n { text-align: right; white-space: nowrap; font-variant-numeric: tabular-nums; }
        .audit-table .neg { color: #dc2626; } .audit-table .pos { color: #16a34a; }
        .audit-table .muted { opacity: .6; }
        .audit-table tfoot th { border-top: 2px solid rgba(128,128,128,.4); }
    </style>

    <x-filament::section>
        {{ $this->filtersForm }}
        <p class="muted" style="font-size:.8rem;margin-top:.5rem">Leave both dates empty for the entire history. With a date window the running totals start from an opening balance.</p>
    </x-filament::section>

    @php($report = $this->getReport())

    @if (! $report)
        <x-filament::section>Select an employee.</x-filament::section>
    @elseif ($report->sections === [])
        <x-filament::section>No entries for this selection.</x-filament::section>
    @else
        @foreach ($report->sections as $section)
            <x-filament::section>
                <x-slot name="heading">
                    {{ $report->employeeName }} — {{ $section->period }}
                    @if ($section->frozen)
                        <x-filament::badge color="warning" tag="span">frozen by manual adjustments</x-filament::badge>
                    @endif
                </x-slot>

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
            </x-filament::section>
        @endforeach
    @endif
</x-filament-panels::page>
