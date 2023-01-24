<div id="dashboard" class="dashboard">
    <h2>Dashboard</h2>
    <section class="top">
        <div id="piechart1" class="charts head">
            <h3>Pie Chart 1</h3>
        </div>

        <div id="piechart2" class="charts">
            <h4>Pie Chart 2</h4>
        </div>

        <div id="piechart3" class="charts">
            <h4>Pie Chart 3</h4>
        </div>

        <div id="piechart4" class="charts">
            <h4>Pie Chart 4</h4>
        </div>
    </section>

    <section class="middle">
        <div id="columnchart1" class="charts">
            <h4>Column chart 1</h4>
        </div>

        <div id="columnchart2" class="charts">
            <h4>Column Chart 2</h4>
        </div>

        <div id="columnchart3" class="charts">
            <h4>Column Chart 3</h4>
        </div>

    </section>

    <section class="bottom">
        <div id="left" class="sides">
            <h4>Highest Dues By Floor</h4>
            @if ($gm !== null)
            <label for="">Ground Floor: <span>{{ $gm->name.' ['.$gm->current_balance.' Tk]' }}</span></label>
            @endif
            @if ($gm !== null)
            <label for="">1st Floor: <span>{{ $fm->name.' ['.$fm->current_balance.' Tk]' }}</span></label>
            @endif
            @if ($gm !== null)
            <label for="">2nd Floor: <span>{{ $sm->name.' ['.$sm->current_balance.' Tk]' }}</span></label>
            @endif
        </div>

        <div id="right" class="sides">
            <legend>Floor Rents</legend>

            <form action="{{ route('settings.update',1) }}" method="POST" id="home_rent_form">
                <label for="ground_floor_rent" class="form-label">Ground Floor Rent</label>
                <span id="home_ground_floor_rent_error" class="home-rent-error"></span>
                <input type="number" name="ground_floor_rent" id="ground_floor_rent" placeholder="enter ground floor rent" class="form-control" value="{{ getSetting('Ground Floor Rent')->value }}">

                <label for="ground_floor_rent" class="form-label">1st Floor Rent</label>
                <span id="home_first_floor_rent_error" class="home-rent-error"></span>
                <input type="number" name="ground_1st_rent" id="1st_floor_rent" placeholder="enter 1st floor rent" class="form-control" value="{{ getSetting('1st Floor Rent')->value }}">

                <label for="ground_floor_rent" class="form-label">2nd Floor Rent</label>
                <span id="home_second_floor_rent_error" class="home-rent-error"></span>
                <input type="number" name="2nd_floor_rent" id="2nd_floor_rent" placeholder="enter 2nd floor rent" class="form-control" value="{{ getSetting('2nd Floor Rent')->value }}">

                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" id="home_rent_form_restore" class="btn btn-secondary">Restore</button>
                </div>
            </form>
        </div>
    </section>
</div>
