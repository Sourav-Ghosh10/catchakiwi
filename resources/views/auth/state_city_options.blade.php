@foreach ($cities as $state)
    <ul>
        @foreach ($state['cities'] as $city)
            @foreach ($city['towns'] as $town)
                <option value="{{$town['id']}}">{{ $town['suburb_name'] }},{{ $city['name'] }},{{ $state['name'] }}</option>
            @endforeach 
        @endforeach
    </ul>
@endforeach