<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Zaman Mess</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- default css --}}
        <link rel="stylesheet" href="{{ asset('css/default/index.css') }}">
        <link rel="stylesheet" href="{{ asset('css/default/home.css') }}">

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
                <a href="{{ route('index') }}" class="logo">Calefornia Co-op</a>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('members.index') }}">Members</a></li>
                    <li><a href="{{ route('months.index') }}">Months</a></li>
                    <li><a href="{{ route('payments.index') }}">Payments</a></li>
                    <li><a href="{{ route('adjustments.index') }}">Adjustments</a></li>
                    <li><a href="{{ route('notices.index') }}">Notices</a></li>
                </ul>
                <ul>
                    {{-- @if (1) --}}
                    <li id="login"><a href="{{ route('login') }}">Login</a></li>
                    {{-- @else --}}
                    <li id="prodile"><a href="{{ '#' }}">Profile</a></li>
                    <li id="login"><a href="{{ route('logout') }}">Logout</a></li>
                    {{-- @endif --}}
                </ul>
            </nav>
        </header>

        <main>
            <h1>ABC</h1>
            <h6>Calefornia, USA</h6>
        </main>

        <section class="content-body">
            <section id="content_loader" class="content-loader">
                <h2>Content Body</h2>
            </section>

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
                        <tr class="clickable" date-href={{ route('notices.show',$notice->id) }}>
                            <td>{{ $notice->created_at->diffForHumans() }}</td>
                            <td>{{ Str::limit($notice->heading,10,'...') }}</td>
                            <td>{{ $notice->user->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </aside>
        </section>

        <footer>
            <h2>Contact</h2>

            <div class="footer-contents">
                <div class="sides left">
                    <label for="" class="form-label">Mobile</label>
                    <label for="" class="form-label">Email</label>
                    <label for="" class="form-label">Address</label>
                </div>

                <div class="sides">
                    <label for="" class="form-label">+8801751430596,+8801847437223</label>
                    <label for="" class="form-label">heemaun@gmail.com</label>
                    <p>
                        North-East of Baitul Mamur Jame Masjid,
                        Suihari-Golapbabh Road, Suihari
                        Dinajpur - 5200
                    </p>
                </div>
            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        {{-- default js --}}
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
    </body>
</html>
