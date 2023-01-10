<div class="home">
    <div class="top">
        <select id="home_month_name_select">
            <option value="all">All</option>
            @foreach ($months as $month)
            <option value="{{ $month->id }}">{{ $month->name }}</option>
            @endforeach
        </select>
    </div>
    {{-- <div class="table-container">
        <div class="table-details">
            <h3>Ground Floor</h3>
            <table class="table table-bordered table-dark table-hover table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Member</th>
                        <th>Payment</th>
                        <th>Adjustment</th>
                        <th>Rent</th>
                        <th>Due</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groundMembersMonths as $mm)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ss->member->name }}</td>
                        <td>
                            @foreach ($ss->payments::where('status','active')->get() as $payment)
                            {{ $payment->amount }}
                            @if (!$loop->last)
                            {{ ',' }}
                            @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($ss->adjustments::where('status','active')->get() as $adjustment)
                            {{ $adjustment->amount }}
                            @if (!$loop->last)
                            {{ ',' }}
                            @endif
                            @endforeach
                        </td>
                        <td>{{ $ss->rent_this_month }}</td>
                        <td>{{ $ss->due }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2"></th>
                        <th>Total Paid: {{ $groundMembersMonthsTotalPaid }}</th>
                        <th>Total Adjustment: {{ $groundMembersMonthsTotalAdjustment }}</th>
                        <th>Total Due: {{ $groundMembersMonthsTotalDue }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="table-details">
            <h3>First Floor</h3>
            <table class="table table-bordered table-dark table-hover table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Member</th>
                        <th>Payment</th>
                        <th>Adjustment</th>
                        <th>Rent</th>
                        <th>Due</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($firstMembersMonths as $mm)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ss->member->name }}</td>
                        <td>
                            @foreach ($ss->payments as $payment)
                            {{ $payment->amount }}
                            @if (!$loop->last)
                            {{ ',' }}
                            @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($ss->adjustments as $adjustment)
                            {{ $adjustment->amount }}
                            @if (!$loop->last)
                            {{ ',' }}
                            @endif
                            @endforeach
                        </td>
                        <td>{{ $ss->rent_this_month }}</td>
                        <td>{{ $ss->due }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2"></th>
                        <th>Total Paid: {{ $firstMembersMonthsTotalPaid }}</th>
                        <th>Total Adjustment: {{ $firstMembersMonthsTotalAdjustment }}</th>
                        <th>Total Due: {{ $firstMembersMonthsTotalDue }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="table-details">
            <h3>Second Floor</h3>
            <table class="table table-bordered table-dark table-hover table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Member</th>
                        <th>Payment</th>
                        <th>Adjustment</th>
                        <th>Rent</th>
                        <th>Due</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($secondMembersMonths as $mm)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ss->member->name }}</td>
                        <td>
                            @foreach ($ss->payments as $payment)
                            {{ $payment->amount }}
                            @if (!$loop->last)
                            {{ ',' }}
                            @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($ss->adjustments as $adjustment)
                            {{ $adjustment->amount }}
                            @if (!$loop->last)
                            {{ ',' }}
                            @endif
                            @endforeach
                        </td>
                        <td>{{ $ss->rent_this_month }}</td>
                        <td>{{ $ss->due }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2"></th>
                        <th>Total Paid: {{ $secondMembersMonthsTotalPaid }}</th>
                        <th>Total Adjustment: {{ $secondMembersMonthsTotalAdjustment }}</th>
                        <th>Total Due: {{ $secondMembersMonthsTotalDue }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="table-details">
            <span>Total Payment: {{ $groundMembersMonthsTotalPaid+$firstMembersMonthsTotalPaid+$secondMembersMonthsTotalPaid }}</span>
            <span>Total Due: {{ $groundMembersMonthsTotalDue+$secondMembersMonthsTotalDue+$secondMembersMonthsTotalDue }}</span>
        </div>
    </div> --}}
</div>
