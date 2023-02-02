{{-- home month view template --}}
<div id="ground_floor_table_div" class="table-details">
    <h3>Ground Floor</h3>
    <table class="table table-bordered table-dark table-hover table-striped">
        <thead>
            <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2">Member</th>
                <th colspan="2" class="hide-in-low-res">Payment</th>
                <th colspan="2" class="hide-in-low-res">Adjustment</th>
                <th rowspan="2">Rent</th>
                <th rowspan="2">Due</th>
            </tr>
            <tr class="hide-in-low-res">
                <th>Details</th>
                <th>Total</th>
                <th>Details</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groundMembersMonths as $mm)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="left">{{ $mm->member->name }}</td>
                <td class="td-flex hide-in-low-res">
                    @if (count($mm->payments->where('status','active'))==0)
                    {{ '-' }}
                    @else
                    @foreach ($mm->payments->where('status','active') as $payment)
                    <span class="td-span-parent">
                        <span>{{ number_format($payment->amount) }}</span>
                        <span>{{ '['.date('d/m/Y',strtotime($payment->created_at)).']' }}</span>
                    </span>
                    @endforeach
                    @endif
                </td>
                <td class="right hide-in-low-res">
                    <span>{{ number_format($mm->payments->where('status','active')->sum('amount')) }}</span>
                </td>
                <td class="td-flex hide-in-low-res">
                    @if (count($mm->adjustments->where('status','active'))==0)
                    {{ '-' }}
                    @else
                    @foreach ($mm->adjustments->where('status','active') as $adjustment)
                    <span class="td-span-parent">
                        <span>{{ number_format($adjustment->amount) }}</span>
                        <span>{{ '['.date('d/m/Y',strtotime($adjustment->created_at)).']' }}</span>
                    </span>
                    @endforeach
                    @endif
                </td>
                <td class="right hide-in-low-res">
                    <span>{{ number_format($mm->adjustments->where('status','active')->sum('amount')) }}</span>
                </td>
                <td class="right">{{ number_format($mm->rent_this_month) }}</td>
                <td class="right">{{ number_format($mm->due) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total Member: {{ count($groundMembersMonths) }}</th>
                <th colspan="2" class="hide-in-low-res">Total Paid: {{ number_format($groundTotalPaid) }}</th>
                <th colspan="2" class="hide-in-low-res">Total Adjustment: {{ number_format($groundTotalAdjustment) }}</th>
                <th>Total Rent: {{ number_format($groundTotalRent) }}</th>
                <th>Total Due: {{ number_format($groundTotalDue) }}</th>
            </tr>
        </tfoot>
    </table>
</div>

<div id="first_floor_table_div" class="table-details">
    <h3>First Floor</h3>
    <table class="table table-bordered table-dark table-hover table-striped">
        <thead>
            <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2">Member</th>
                <th colspan="2" class="hide-in-low-res">Payment</th>
                <th colspan="2" class="hide-in-low-res">Adjustment</th>
                <th rowspan="2">Rent</th>
                <th rowspan="2">Due</th>
            </tr>
            <tr class="hide-in-low-res">
                <th>Details</th>
                <th>Total</th>
                <th>Details</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($firstMembersMonths as $mm)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="left">{{ $mm->member->name }}</td>
                <td class="td-flex hide-in-low-res">
                    @if (count($mm->payments->where('status','active'))==0)
                    {{ '-' }}
                    @else
                    @foreach ($mm->payments->where('status','active') as $payment)
                    <span class="td-span-parent">
                        <span>{{ number_format($payment->amount) }}</span>
                        <span>{{ '['.date('d/m/Y',strtotime($payment->created_at)).']' }}</span>
                    </span>
                    @endforeach
                    @endif
                </td>
                <td class="right hide-in-low-res">
                    <span>{{ number_format($mm->payments->where('status','active')->sum('amount')) }}</span>
                </td>
                <td class="td-flex hide-in-low-res">
                    @if (count($mm->adjustments->where('status','active'))==0)
                    {{ '-' }}
                    @else
                    @foreach ($mm->adjustments->where('status','active') as $adjustment)
                    <span class="td-span-parent">
                        <span>{{ number_format($adjustment->amount) }}</span>
                        <span>{{ '['.date('d/m/Y',strtotime($adjustment->created_at)).']' }}</span>
                    </span>
                    @endforeach
                    @endif
                </td>
                <td class="right hide-in-low-res">
                    <span>{{ number_format($mm->adjustments->where('status','active')->sum('amount')) }}</span>
                </td>
                <td class="right">{{ number_format($mm->rent_this_month) }}</td>
                <td class="right">{{ number_format($mm->due) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total Member: {{ count($firstMembersMonths) }}</th>
                <th colspan="2" class="hide-in-low-res">Total Paid: {{ number_format($firstTotalPaid) }}</th>
                <th colspan="2" class="hide-in-low-res">Total Adjustment: {{ number_format($firstTotalAdjustment) }}</th>
                <th>Total Rent: {{ number_format($firstTotalRent) }}</th>
                <th>Total Due: {{ number_format($firstTotalDue) }}</th>
            </tr>
        </tfoot>
    </table>
</div>

<div id="second_floor_table_div" class="table-details">
    <h3>Second Floor</h3>
    <table class="table table-bordered table-dark table-hover table-striped">
        <thead>
            <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2">Member</th>
                <th colspan="2" class="hide-in-low-res">Payment</th>
                <th colspan="2" class="hide-in-low-res">Adjustment</th>
                <th rowspan="2">Rent</th>
                <th rowspan="2">Due</th>
            </tr>
            <tr class="hide-in-low-res">
                <th>Details</th>
                <th>Total</th>
                <th>Details</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($secondMembersMonths as $mm)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="left">{{ $mm->member->name }}</td>
                <td class="td-flex hide-in-low-res">
                    @if (count($mm->payments->where('status','active'))==0)
                    {{ '-' }}
                    @else
                    @foreach ($mm->payments->where('status','active') as $payment)
                    <span class="td-span-parent">
                        <span>{{ number_format($payment->amount) }}</span>
                        <span>{{ '['.date('d/m/Y',strtotime($payment->created_at)).']' }}</span>
                    </span>
                    @endforeach
                    @endif
                </td>
                <td class="right hide-in-low-res">
                    <span>{{ number_format($mm->payments->where('status','active')->sum('amount')) }}</span>
                </td>
                <td class="td-flex hide-in-low-res">
                    @if (count($mm->adjustments->where('status','active'))==0)
                    {{ '-' }}
                    @else
                    @foreach ($mm->adjustments->where('status','active') as $adjustment)
                    <span class="td-span-parent">
                        <span>{{ number_format($adjustment->amount) }}</span>
                        <span>{{ '['.date('d/m/Y',strtotime($adjustment->created_at)).']' }}</span>
                    </span>
                    @endforeach
                    @endif
                </td>
                <td class="right hide-in-low-res">
                    <span>{{ number_format($mm->adjustments->where('status','active')->sum('amount')) }}</span>
                </td>
                <td class="right">{{ number_format($mm->rent_this_month) }}</td>
                <td class="right">{{ number_format($mm->due) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total Member: {{ count($secondMembersMonths) }}</th>
                <th colspan="2" class="hide-in-low-res">Total Paid: {{ number_format($secondTotalPaid) }}</th>
                <th colspan="2" class="hide-in-low-res">Total Adjustment: {{ number_format($secondTotalAdjustment) }}</th>
                <th>Total Rent: {{ number_format($secondTotalRent) }}</th>
                <th>Total Due: {{ number_format($secondTotalDue) }}</th>
            </tr>
        </tfoot>
    </table>
</div>

<div id="all_table_div" class="table-details all-table">
    <span class="total-month"><label>Month Payment:</label>{{ ' '.number_format($groundTotalPaid+$firstTotalPaid+$secondTotalPaid) }}</span>
    <span class="total-month"><label>Month Adjustment:</label>{{ ' '.number_format($groundTotalAdjustment+$firstTotalAdjustment+$secondTotalAdjustment) }}</span>
    <span class="total-month"><label>Month Rent:</label>{{ ' '.number_format($groundTotalRent+$firstTotalRent+$secondTotalRent) }}</span>
    <span class="total-month"><label>Month Due:</label>{{ ' '.number_format($groundTotalDue+$firstTotalDue+$secondTotalDue) }}</span>
</div>
{{-- home month view template end --}}
