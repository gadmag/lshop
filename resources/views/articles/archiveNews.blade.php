<div class="block block-arch-menu">
    <h2 class="dualline">Архив статей</h2>
    <br>
    <div class="block-content">
    <ul class="list-unstyled arch-menu">

        @foreach($archNews as $month)
            {{--{{dd($month)}}--}}
            <li><a href="{{route('article.date',['year' => $month->year, 'month' => $month->month])}}">{{\Carbon\Carbon::createFromDate($month->year,$month->month,1)->formatLocalized('%B')}}
                    {{$month->year}} ({{$month->article_count}})</a></li>
        @endforeach
    </ul>
    </div>
</div>