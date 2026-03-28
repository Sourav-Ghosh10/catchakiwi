@include('includes/admin-header')
@include('includes/admin-sidebar')
<div class="container">
    <h1>Edit {{ ucfirst($type) }}</h1>
    <form action="{{ route('locations.update', ['id' => $location->id, 'type' => $type]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $location->name }}" required>
        </div>
        @if ($type === 'country')
            <div class="form-group">
                <label for="shortname">Short Name</label>
                <input type="text" class="form-control" id="shortname" name="shortname" value="{{ $location->shortname }}">
            </div>
            <div class="form-group">
                <label for="phonecode">Phone Code</label>
                <input type="number" class="form-control" id="phonecode" name="phonecode" value="{{ $location->phonecode }}">
            </div>
        @elseif ($type === 'state')
            <div class="form-group">
                <label for="country_id">Country</label>
                <select name="country_id" id="country_id" class="form-control">
                    @foreach (\App\Models\Country::all() as $country)
                        <option value="{{ $country->id }}" {{ $country->id == $location->country_id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @elseif ($type === 'city')
            <div class="form-group">
                <label for="state_id">State</label>
                <select name="state_id" id="state_id" class="form-control">
                    @foreach (\App\Models\State::all() as $state)
                        <option value="{{ $state->id }}" {{ $state->id == $location->state_id ? 'selected' : '' }}>
                            {{ $state->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @elseif ($type === 'town')
            <div class="form-group">
                <label for="city_id">City</label>
                <select name="city_id" id="city_id" class="form-control">
                    @foreach (\App\Models\City::all() as $city)
                        <option value="{{ $city->id }}" {{ $city->id == $location->city_id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@include('includes/admin-footer')