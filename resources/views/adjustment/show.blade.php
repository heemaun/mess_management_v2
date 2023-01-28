<div id="adjustment_show" class="adjustment-show">
    <div class="top">
        <h2>Adjustment Details</h2>
        <div class="btn-container">
            <a href="{{ route('adjustments.index') }}" id="adjustment_show_back" class="btn btn-secondary">Back</a>
            <button type="button" id="adjustment_show_delete" class="btn btn-danger">Delete</button>
        </div>
    </div>

    <div class="info-container">
        <label for="">Member:<span>{{ $adjustment->memberMonth->member->name }}</span></label>
        <label for="">Month:<span>{{ $adjustment->memberMonth->month->name }}</span></label>
        <label for="">Status:<span>{{ ucwords($adjustment->status) }}</span></label>
        <label for="">Amount:<span>{{ number_format($adjustment->amount) }}</span></label>
        <label for="">Last modified by:<span>{{ $adjustment->user->name }}</span></label>
        <label for="">Created at:<span>{{ date('d/m/Y h:i:s a',strtotime($adjustment->created_at)) }}</span></label>
        <label for="">Updated at:<span>{{ date('d/m/Y h:i:s a',strtotime($adjustment->updated_at)) }}</span></label>
        @if (!empty($adjustment->note))
        <label for="" class="note">Note</label>
        <p>{{ $adjustment->note }}</p>
        @endif
    </div>

    <div id="adjustment_delete_div" class="adjustment-delete-div hide">
        <form action="{{ route('adjustments.destroy',$adjustment) }}" method="POST" id="adjustment_delete_form">
            @csrf
            @method("DELETE")

            <legend>Delete Adjustment</legend>

            <label for="adjustment_delete_password" class="form-label">Enter your password</label>
            <input type="password" id="adjustment_delete_password" placeholder="enter your password" class="form-control">
            <span id="adjustment_delete_password_error" class="adjustment-delete-error"></span>

            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Confirm</button>
                <button type="button" id="adjustment_delete_close" class="btn btn-secondary">Close</button>
            </div>
        </form>
    </div>
</div>
