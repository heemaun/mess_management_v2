<div id="month_show" class="month-show">
    <div class="top">
        <h2>Month Details</h2>
        <div class="btn-container">
            @if (strcmp('inactive',$month->status)==0 || strcmp('pending',$month->status)==0)
            <a href="{{ route('months.update',$month->id) }}" id="month_show_activate" class="btn btn-primary">Activate</a>
            @endif
            <a href="{{ route('months.edit',$month->id) }}" id="month_show_edit" class="btn btn-success">Edit</a>
            <button type="button" id="month_show_delete" class="btn btn-danger">Delete</button>
            <a href="{{ route('months.index') }}" id="month_show_back" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="info-container">
        <label for="">Name:<span>{{ $month->name.' ['.date('Y-F',strtotime($month->name)).']' }}</span></label>
        <label for="">Status:<span>{{ ucwords($month->status) }}</span></label>
        <label for="">Last Modified By:<span>{{ $month->user->name }}</span></label>
        <label for="">Created At<span>{{ date('d/m/Y h:m:i A',strtotime($month->created_at)) }}</span></label>
        <label for="">Updated At<span>{{ date('d/m/Y h:m:i A',strtotime($month->updated_at)) }}</span></label>
    </div>

    <div class="detail-container">
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
                        <td class="left"><a href="{{ route('members.show',$mm->member->id) }}">{{ $mm->member->name }}</a></td>
                        <td class="td-flex hide-in-low-res">
                            @if (count($mm->payments->where('status','active'))==0)
                            {{ '-' }}
                            @else
                            @foreach ($mm->payments->where('status','active') as $payment)
                            <a href="{{ route('payments.show',$payment->id) }}" class="td-span-parent">
                                <span>{{ number_format($payment->amount) }}</span>
                                <span>{{ '['.date('d/m/Y',strtotime($payment->created_at)).']' }}</span>
                            </a>
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
                            <a href="{{ route('adjustments.show',$adjustment->id) }}" class="td-span-parent">
                                <span>{{ number_format($adjustment->amount) }}</span>
                                <span>{{ '['.date('d/m/Y',strtotime($adjustment->created_at)).']' }}</span>
                            </a>
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
                        <td class="left"><a href="{{ route('members.show',$mm->member->id) }}">{{ $mm->member->name }}</a></td>
                        <td class="td-flex hide-in-low-res">
                            @if (count($mm->payments->where('status','active'))==0)
                            {{ '-' }}
                            @else
                            @foreach ($mm->payments->where('status','active') as $payment)
                            <a href="{{ route('payments.show',$payment->id) }}" class="td-span-parent">
                                <span>{{ number_format($payment->amount) }}</span>
                                <span>{{ '['.date('d/m/Y',strtotime($payment->created_at)).']' }}</span>
                            </a>
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
                            <a href="{{ route('adjustments.show',$adjustment->id) }}" class="td-span-parent">
                                <span>{{ number_format($adjustment->amount) }}</span>
                                <span>{{ '['.date('d/m/Y',strtotime($adjustment->created_at)).']' }}</span>
                            </a>
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
                        <td class="left"><a href="{{ route('members.show',$mm->member->id) }}">{{ $mm->member->name }}</a></td>
                        <td class="td-flex hide-in-low-res">
                            @if (count($mm->payments->where('status','active'))==0)
                            {{ '-' }}
                            @else
                            @foreach ($mm->payments->where('status','active') as $payment)
                            <a href="{{ route('payments.show',$payment->id) }}" class="td-span-parent">
                                <span>{{ number_format($payment->amount) }}</span>
                                <span>{{ '['.date('d/m/Y',strtotime($payment->created_at)).']' }}</span>
                            </a>
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
                            <a href="{{ route('adjustments.show',$adjustment->id) }}" class="td-span-parent">
                                <span>{{ number_format($adjustment->amount) }}</span>
                                <span>{{ '['.date('d/m/Y',strtotime($adjustment->created_at)).']' }}</span>
                            </a>
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
    </div>

    <div id="month_delete_div" class="month-delete-div hide">
        <form action="{{ route('months.destroy',$month) }}" method="POST" id="month_delete_form">
            @csrf
            @method("DELETE")

            <legend>Delete Month</legend>

            <label for="month_delete_password" class="form-label">Enter your password</label>
            <input type="password" id="month_delete_password" placeholder="enter your password" class="form-control">
            <span id="month-delete-error" class="month-delete-password-error"></span>

            <input type="checkbox" id="month_delete_permanent" class="form-check-input">
            <label for="month_delete_permanent" class="form-label">Check if delete permanently</label>

            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Confirm</button>
                <button type="button" id="month_delete_close" class="btn btn-secondary">Close</button>
            </div>
        </form>
    </div>
</div>
