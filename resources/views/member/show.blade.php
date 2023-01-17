<div id="member_show" class="member-show">
    <div class="top">
        <h2>Member Details</h2>
        <div class="btn-container">
            <a href="{{ route('members.edit',$member->id) }}" id="member_show_edit" class="btn btn-success">Edit</a>
            <a href="{{ route('members.index') }}" id="member_show_back" class="btn btn-secondary">Back</a>
            <button type="button" id="member_show_delete" class="btn btn-danger">Delete</button>
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
                    <tr>
                        <td class="center">{{ $loop->iteration }}</td>
                        <td class="center">{{ date('Y-m-d h:i:s a',strtotime($p->created_at)) }}</td>
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
