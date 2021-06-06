<div class="">
    <h1>Купоны</h1>
    <div class="panel-heading">
        <a href="{{route('coupons.create')}}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            Добавить купон
        </a>
    </div>
    @if (count($coupons) > 0)
        <div class="panel panel-default">


            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Название</th>
                    <th>Код</th>
                    <th>Статус</th>
                    <th>Скидка</th>
                    <th>Кол-во</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($coupons as $coupon)
                        <tr>
                            <!-- Article title -->
                            <td class="table-link">
                                <div><a href="{{action('Admin\CouponController@edit', [$coupon->id])}}">{{$coupon->name}}</a></div>
                            </td>
                            <td class="table-text">
                                <span>{{$coupon->code}}</span>
                            </td>

                            <td class="table-text">
                                @if($coupon->status == 1)
                                    <span>Опубликованно</span>
                                @else
                                    <span>Нет</span>
                                @endif
                            </td>

                            <td class="table-text">
                                {{$coupon->rawDiscount}}
                            </td>
                            <td class="table-text">
                                {{$coupon->uses_total}}
                            </td>

                            <!-- Edit Button-->
                            <td class="text-right">

                                <a style="display: inline-block" href="{{action('Admin\CouponController@edit',[$coupon->id])}}" class="btn btn-info" title="Редактировать"
                                   data-toggle="tooltip">
                                    <i class="fa fa-edit"></i>
                                </a>


                                <!-- Delete Button -->

                                <form style="display: inline-block" action="{{ url('admin/coupons/'.$coupon->id) }}" method="POST">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}

                                    <button style="display: inline-block" type="submit" class="btn btn-danger" data-toggle="tooltip" title="Удалить">
                                        <i class="fa fa-trash"></i> Удалить
                                    </button>
                                </form>


                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$coupons->links()}}
            </div>
        </div>

    @endif
</div>