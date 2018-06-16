<rss xmlns:atom="http://www.w3.org/2005/Atom" xmlns:yandex="http://news.yandex.ru" version="2.0">
    <channel>
    <title>Голосстепи новости</title>
    <link>{{URL::to('/')}}</link>
    <description>Ежедневная газета</description>
    <language>ru</language>
    @foreach($news as $item)
            <item>
                <title>{{$item->title}}</title>
                <link>{{route('news.show',['alias' => $item->id])}}</link>
                <pubDate>{{Carbon\Carbon::parse($item->created_at,'Europe/Moscow')->toRfc2822String()}}</pubDate>
                <yandex:full-text><![CDATA[{{$item->body}}]]></yandex:full-text>
                @if($item->description)
                <description><![CDATA[{!! $item->description !!}]]></description>
                @endif
                @if($item->files->first())
                    <enclosure
                            url="{{asset('storage/files/400x300/'.$item->files()->first()->filename)}}"
                            type="{{$item->files()->first()->mime}}"/>
                @endif

                @if($item->catalogs->first())
                <category>{{$item->catalogs()->first()->name}}</category>
                @endif
                <author>{{$item->user->name}}</author>
            </item>
    @endforeach
    </channel>
</rss>