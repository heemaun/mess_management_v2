<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Zaman Mess</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- default css --}}
        <link rel="stylesheet" href="{{ asset('css/default/index.css') }}">
        <link rel="stylesheet" href="{{ asset('css/default/home.css') }}">
        <link rel="stylesheet" href="{{ asset('css/default/dashboard.css') }}">

        {{-- user css --}}
        <link rel="stylesheet" href="{{ asset('css/user/index.css') }}">
        <link rel="stylesheet" href="{{ asset('css/user/show.css') }}">
        <link rel="stylesheet" href="{{ asset('css/user/create.css') }}">
        <link rel="stylesheet" href="{{ asset('css/user/edit.css') }}">

        {{-- member css --}}
        <link rel="stylesheet" href="{{ asset('css/member/index.css') }}">
        <link rel="stylesheet" href="{{ asset('css/member/show.css') }}">
        <link rel="stylesheet" href="{{ asset('css/member/create.css') }}">
        <link rel="stylesheet" href="{{ asset('css/member/edit.css') }}">

        {{-- month css --}}
        <link rel="stylesheet" href="{{ asset('css/month/index.css') }}">
        <link rel="stylesheet" href="{{ asset('css/month/show.css') }}">
        <link rel="stylesheet" href="{{ asset('css/month/create.css') }}">
        <link rel="stylesheet" href="{{ asset('css/month/edit.css') }}">

        {{-- member-month css --}}
        <link rel="stylesheet" href="{{ asset('css/member-month/index.css') }}">
        <link rel="stylesheet" href="{{ asset('css/member-month/show.css') }}">
        <link rel="stylesheet" href="{{ asset('css/member-month/create.css') }}">
        <link rel="stylesheet" href="{{ asset('css/member-month/edit.css') }}">

        {{-- payment css --}}
        <link rel="stylesheet" href="{{ asset('css/payment/index.css') }}">
        <link rel="stylesheet" href="{{ asset('css/payment/show.css') }}">
        <link rel="stylesheet" href="{{ asset('css/payment/create.css') }}">
        <link rel="stylesheet" href="{{ asset('css/payment/edit.css') }}">

        {{-- adjustment css --}}
        <link rel="stylesheet" href="{{ asset('css/adjustment/index.css') }}">
        <link rel="stylesheet" href="{{ asset('css/adjustment/show.css') }}">
        <link rel="stylesheet" href="{{ asset('css/adjustment/create.css') }}">
        <link rel="stylesheet" href="{{ asset('css/adjustment/edit.css') }}">

        {{-- notice css --}}
        <link rel="stylesheet" href="{{ asset('css/notice/index.css') }}">
        <link rel="stylesheet" href="{{ asset('css/notice/show.css') }}">
        <link rel="stylesheet" href="{{ asset('css/notice/create.css') }}">
        <link rel="stylesheet" href="{{ asset('css/notice/edit.css') }}">
    </head>

    <body>
        <header>
            <nav>
                <a href="{{ route('index') }}" class="logo">Zaman Mess</a>

                @if (checkLogin())
                <ul id="navbar" class="center-ul">
                    <li><a href="{{ route('home') }}" id="home">Home</a></li>
                    <li><a href="{{ route('months.index') }}">Months</a></li>
                    <li><a href="{{ route('members.index') }}">Members</a></li>
                    <li><a href="{{ route('payments.index') }}">Payments</a></li>
                    <li><a href="{{ route('adjustments.index') }}">Adjustments</a></li>
                    <li><a href="{{ route('notices.index') }}">Notices</a></li>
                    <li><a href="{{ route('users.index') }}">User</a></li>
                </ul>
                <span id="center_ul_toggler" class="center-ul-open"><svg xmlns="http://www.w3.org/2000/svg" height="48" width="48"><path d="M24 40 8 24 24 8l2.1 2.1-12.4 12.4H40v3H13.7l12.4 12.4Z"/></svg></span>
                @endif

                @if (checkLogin())
                <span id="right_trigger" class="right-trigger">{{ getUser()->name }}</span>
                <ul id="right_ul" class="right-ul hide">
                    <li id="profile"><a href="{{ route('users.show',getUser()->id) }}">Profile</a></li>
                    <li id="change_password"><a href="{{ '#' }}">Change Password</a></li>
                    <li id="logout"><a href="{{ route('logout') }}">Logout</a></li>
                </ul>
                @else
                <span id="login" class="right-trigger">Login</span>
                @endif

            </nav>
        </header>

        {{-- site banner space --}}
        @if (!checkLogin())
        <main>
            <h1>ABC</h1>
            <h6>Calefornia, USA</h6>
        </main>
        @endif
        {{-- site banner space end --}}

        <section class="content-body">
            {{-- the part all content will load through ajax --}}
            <section id="content_loader" class="content-loader">
            </section>
            {{-- the part all content will load through ajax end --}}

            @if (!checkLogin())
            {{-- public notice board --}}
            <aside>
                <h2>Notices</h2>
                <table class="table table-bordered table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Heading</th>
                            <th>Posted By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notices as $notice)
                        <tr class="clickable" data-href={{ route('notices.show',$notice->id) }}>
                            <td>{{ $notice->created_at->diffForHumans() }}</td>
                            <td>{{ Str::limit($notice->heading,10,'...') }}</td>
                            <td>{{ $notice->user->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </aside>
            {{-- public notice board end --}}
            @endif
        </section>

        <footer>
            <h2>Contact</h2>

            <div class="footer-contents">
                <div class="sides left">
                    <label for="" class="form-label">Mobile</label>
                    <label for="" class="form-label email">Email</label>
                    <label for="" class="form-label">Address</label>
                </div>

                <div class="sides">
                    <label for="" class="form-label">+8801751430596, +8801847437223</label>
                    <label for="" class="form-label">heemaun@gmail.com</label>
                    <p>
                        North-East of Baitul Mamur Jame Masjid,
                        Suihari-Golapbabh Road, Suihari
                        Dinajpur - 5200
                    </p>
                </div>
            </div>
        </footer>

        @if (!checkLogin())
        {{-- notice viewer --}}
        <section id="home_notice_view" class="home-notice-view hide">

        </section>
        {{-- notice viewer end --}}

        {{-- login div --}}
        <section id="login_div" class="login-div hide">
            <form action="{{ route('login') }}" method="POST" id="login_form">
                @csrf
                <legend>Login</legend>

                <label for="login_email" class="form-label">Email</label>
                <input type="email" name="email" id="login_email" class="form-control" placehcurrenter="enter your email" autocomplete="OFF">
                <span id="login_email_error" class="login-error"></span>

                <label for="login-password" class="form-label">Password</label>
                <input type="password" name="password" id="login_password" class="form-control" placehcurrenter="enter your password" autocomplete="OFF">
                <span id="login_password_error" class="login-error"></span>

                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <button type="button" id="login_div_close" class="btn btn-secondary">Close</button>
                </div>
            </form>
        </section>
        {{-- login div end --}}

        @else
        {{-- change password div --}}
        <section id="change_password_div" class="change-password-div hide">
            <form action="{{ route('users.update',getUser()->id) }}" method="POST" id="change_password_form">
                @csrf
                @method("PUT")

                <legend>Change Password</legend>

                <div class="form-group">
                    <label for="change_password_current" class="form-label">Enter current password</label>
                    <input type="password" id="change_password_current" name="current_password" placehcurrenter="enter current password" autocomplete="OFF" class="form-control">
                    <span id="change_password_current_password_error" class="change-password-error"></span>
                </div>

                <div class="form-group">
                    <label for="change_password_new" class="form-label">Enter new password</label>
                    <input type="password" id="change_password_new" name="new_password" placehcurrenter="enter new password" autocomplete="OFF" class="form-control">
                    <span id="change_password_new_password_error" class="change-password-error"></span>
                </div>

                <div class="form-group">
                    <label for="change_password_confirm" class="form-label">Confirm new password</label>
                    <input type="password" id="change_password_confirm" name="confirm_password" placehcurrenter="confirm new password" autocomplete="OFF" class="form-control">
                    <span id="change_password_new_password_confirmation_error" class="change-password-error"></span>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">Change</button>
                    <button type="button" id="change_password_close" class="btn btn-secondary">Close</button>
                </div>
            </form>
        </section>
        {{-- change password div end --}}
        @endif

        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        {{-- default js --}}
        <script src="{{ asset('js/default/dashboard.js') }}"></script>
        <script src="{{ asset('js/default/index.js') }}"></script>
        <script src="{{ asset('js/default/home.js') }}"></script>

        {{-- user js --}}
        <script src="{{ asset('js/user/index.js') }}"></script>
        <script src="{{ asset('js/user/show.js') }}"></script>
        <script src="{{ asset('js/user/create.js') }}"></script>
        <script src="{{ asset('js/user/edit.js') }}"></script>

        {{-- member js --}}
        <script src="{{ asset('js/member/index.js') }}"></script>
        <script src="{{ asset('js/member/show.js') }}"></script>
        <script src="{{ asset('js/member/create.js') }}"></script>
        <script src="{{ asset('js/member/edit.js') }}"></script>

        {{-- month js --}}
        <script src="{{ asset('js/month/index.js') }}"></script>
        <script src="{{ asset('js/month/show.js') }}"></script>
        <script src="{{ asset('js/month/create.js') }}"></script>
        <script src="{{ asset('js/month/edit.js') }}"></script>

        {{-- member-month js --}}
        <script src="{{ asset('js/member-month/index.js') }}"></script>
        <script src="{{ asset('js/member-month/show.js') }}"></script>
        <script src="{{ asset('js/member-month/create.js') }}"></script>
        <script src="{{ asset('js/member-month/edit.js') }}"></script>

        {{-- payment js --}}
        <script src="{{ asset('js/payment/index.js') }}"></script>
        <script src="{{ asset('js/payment/show.js') }}"></script>
        <script src="{{ asset('js/payment/create.js') }}"></script>
        <script src="{{ asset('js/payment/edit.js') }}"></script>

        {{-- adjustment js --}}
        <script src="{{ asset('js/adjustment/index.js') }}"></script>
        <script src="{{ asset('js/adjustment/show.js') }}"></script>
        <script src="{{ asset('js/adjustment/create.js') }}"></script>
        <script src="{{ asset('js/adjustment/edit.js') }}"></script>

        {{-- notice js --}}
        <script src="{{ asset('js/notice/index.js') }}"></script>
        <script src="{{ asset('js/notice/show.js') }}"></script>
        <script src="{{ asset('js/notice/create.js') }}"></script>
        <script src="{{ asset('js/notice/edit.js') }}"></script>

        @stack("js")
    </body>
</html>
