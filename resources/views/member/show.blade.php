<div id="member_show" class="member-show">
    <div class="top">
        <h2>Member Details</h2>
        <div class="btn-container">
            <a href="{{ route('payments.create') }}" data-id="{{ $member->id }}" data-floor="{{ $member->floor }}" id="member_show_add_payment" class="btn btn-primary">Add Payment</a>
            <a href="{{ route('members.edit',$member->id) }}" id="member_show_edit" class="btn btn-success">Edit</a>
            <button type="button" id="member_show_delete" class="btn btn-danger">Delete</button>
            <a href="{{ route('members.index') }}" id="member_show_back" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="image-viewer">
        <img src="{{ asset('images/default_member_picture_male.png') }}" alt="">
    </div>

    <div class="details-container">
        <div class="info-container">
            <h3>Member Information</h3>
            <label for="">Name:<span>{{ $member->name }}</span></label>
            <label for="">Status:<span>{{ ucwords($member->status) }}</span></label>
            <label for="">Floor:<span>{{ $member->floor }}</span></label>
            <label for="">Email:<span>{{ $member->email }}</span></label>
            <label for="">Phone:<span>{{ $member->phone }}</span></label>
            <label for="">Initial Balance:<span>{{ $member->initial_balance }}</span></label>
            <label for="">Current Balance:<span>{{ $member->current_balance }}</span></label>
            <label for="">Joining Date:<span>{{ date('d/m/Y',strtotime($member->joining_date)) }}</span></label>
            @if (strcmp($member->status,'deleted')===0)
            <label for="">Leaving Date:<span>{{ date('d/m/Y',strtotime($member->leaving_date)) }}</span></label>
            @endif
            <label for="">Last Modified By:<span>{{ $member->user->name }}</span></label>
            <label for="">Created At<span>{{ date('d/m/Y h:m:i A',strtotime($member->created_at)) }}</span></label>
            <label for="">Updated At<span>{{ date('d/m/Y h:m:i A',strtotime($member->updated_at)) }}</span></label>
        </div>

        <div class="payment-details">
            <h3>Last 5 payments</h3>
            <table class="table table-dark table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $p)
                    <tr class="clickable" data-href="{{ route('payments.show',$p->id) }}">
                        <td class="center">{{ $loop->iteration }}</td>
                        <td class="center">{{ date('d/m/Y h:i:s a',strtotime($p->created_at)) }}</td>
                        <td class="right">{{ number_format($p->amount) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="center" colspan="3"><a href="{{ route('payments.index') }}">See all payments</a></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="member-history">
        <h3>Month details</h3>
            <table class="table table-dark table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Month</th>
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
                    @foreach ($membersMonths as $mm)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="left"><a href="{{ route('months.show',$mm->month->id ) }}">{{ $mm->month->name }}</a></td>
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
            </table>
    </div>

    <div id="member_delete_div" class="member-delete-div hide">
        <form action="{{ route('members.destroy',$member) }}" method="POST" id="member_delete_form">
            @csrf
            @method("DELETE")

            <legend>Delete Member</legend>

            <label for="member_delete_password" class="form-label">Enter your password</label>
            <input type="password" id="member_delete_password" placeholder="enter your password" class="form-control">
            <span id="member-delete-error" class="member-delete-password-error"></span>

            <input type="checkbox" id="member_delete_permanent" class="form-check-input">
            <label for="member_delete_permanent" class="form-label">Check if delete permanently</label>

            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Confirm</button>
                <button type="button" id="member_delete_close" class="btn btn-secondary">Close</button>
            </div>
        </form>
    </div>
</div>
