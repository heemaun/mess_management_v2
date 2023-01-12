<h3 id="home_notice_view_header">{{ $notice->heading }}</h3>
<p id="home_notice_view_body" class="body">{{ $notice->body }}</p>
<p id="home_notice_view_footer" class="footer">
    <span id="home_notice_view_admin" class="admin">{{ $notice->user->name }}</span>
    <span id="home_notice_view_time" class="date">{{ date('D, M-d, Y',strtotime($notice->created_at)) }}</span>
</p>
<span id="home_notice_view_close" class="close">X</span>
