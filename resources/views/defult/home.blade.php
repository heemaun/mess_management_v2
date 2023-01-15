<div class="home">
    <div class="top">
        <div class="form-group">
            <label for="" class="form-label">Select a month</label>
            <select id="home_month_name_select" class="form-select">
                @foreach ($months as $month)
                <option value="{{ $month->id }}" {{ ($loop->iteration === 1) ? 'selected' : '' }}>{{ date('Y-M',strtotime($month->name)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="" class="form-label">Select Floor</label>
            <select id="home_floor_select" class="form-select">
                <option value="all" selected>All</option>
                <option value="ground_floor">Ground Floor</option>
                <option value="first_floor">1st Floor</option>
                <option value="second_floor">2nd Floor</option>
            </select>
        </div>
    </div>
    <div id="table_container" class="table-container">
        <div id="ground_floor_table_div" class="table-details">
            <h3>Ground Floor</h3>
            <table class="table table-bordered table-dark table-hover table-striped">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Member</th>
                        <th colspan="2">Payment</th>
                        <th colspan="2">Adjustment</th>
                        <th rowspan="2">Rent</th>
                        <th rowspan="2">Due</th>
                    </tr>
                    <tr>
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
                        <td class="td-flex">
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
                        <td class="right">
                            <span>{{ number_format($mm->payments->where('status','active')->sum('amount')) }}</span>
                        </td>
                        <td class="td-flex">
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
                        <td class="right">
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
                        <th colspan="2">Total Paid: {{ number_format($groundTotalPaid) }}</th>
                        <th colspan="2">Total Adjustment: {{ number_format($groundTotalAdjustment) }}</th>
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
                        <th colspan="2">Payment</th>
                        <th colspan="2">Adjustment</th>
                        <th rowspan="2">Rent</th>
                        <th rowspan="2">Due</th>
                    </tr>
                    <tr>
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
                        <td class="td-flex">
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
                        <td class="right">
                            <span>{{ number_format($mm->payments->where('status','active')->sum('amount')) }}</span>
                        </td>
                        <td class="td-flex">
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
                        <td class="right">
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
                        <th colspan="2">Total Paid: {{ number_format($firstTotalPaid) }}</th>
                        <th colspan="2">Total Adjustment: {{ number_format($firstTotalAdjustment) }}</th>
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
                        <th colspan="2">Payment</th>
                        <th colspan="2">Adjustment</th>
                        <th rowspan="2">Rent</th>
                        <th rowspan="2">Due</th>
                    </tr>
                    <tr>
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
                        <td class="td-flex">
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
                        <td class="right">
                            <span>{{ number_format($mm->payments->where('status','active')->sum('amount')) }}</span>
                        </td>
                        <td class="td-flex">
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
                        <td class="right">
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
                        <th colspan="2">Total Paid: {{ number_format($secondTotalPaid) }}</th>
                        <th colspan="2">Total Adjustment: {{ number_format($secondTotalAdjustment) }}</th>
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
    </div>
</div>
