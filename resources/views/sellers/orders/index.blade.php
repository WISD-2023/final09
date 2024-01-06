@extends('sellers.layouts.master')

@section('page-title', '訂單管理')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">訂單管理</h1>

        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="text-align:left">#</th>
                <th scope="col" style="text-align:left">買家</th>
                <th scope="col" style="text-align:left">訂單狀態</th>
                <th scope="col" style="text-align:left">建立日期</th>
                <th scope="col" style="text-align:center">操作</th>
{{--                <th scope="col" style="text-align:center">刪除</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->user_id }}</td>
                    <td> @if ($order->status == '1')
                            <div style="color:#FF0000; font-weight:bold;">
                                (待確認)
                            </div>
                        @elseif ($order->status == '0')
                            <div style="color:#ff6f00; font-weight:bold;">
                                (買家待付款)
                            </div>
                        @elseif ($order->status == '2')
                            <div style="color:#ff6f00; font-weight:bold;">
                                (出貨中)
                            </div>
                        @elseif ($order->status == '3')
                            <div style="color:#ffea00; font-weight:bold;">
                                (已出貨)
                            </div>
                        @elseif ($order->status == '4')
                            <div style="color:#48ff00; font-weight:bold;">
                                (已送達)
                            </div>
                        @elseif ($order->status == '5')
                            <div style="color:#002aff; font-weight:bold;">
                                (已完成)
                            </div>
                        @elseif ($order->status == '6')
                            <div style="color:#002aff; font-weight:bold;">
                                (退貨)
                            </div>
                        @elseif ($order->status == '7')
                            <div style="color:#002aff; font-weight:bold;">
                                (取消)
                            </div>
                        @elseif ($order->status == '8')
                            <div style="color:#002aff; font-weight:bold;">
                                (未成立)
                            </div>

                        @endif</td>
                    <td>{{ $order->date }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('sellers.orders.edit',$order->id) }}" class="btn btn-secondary btn-sm">檢視訂單</a>
                    </td>
                    <td style="text-align:center">
{{--                        <form action="{{ route('sellers.products.destroy',$product->id) }}" method="POST">--}}
{{--                            @method('DELETE')--}}
{{--                            @csrf--}}
{{--                            <button type="submit" class="btn btn-danger btn-sm">刪除</button>--}}
{{--                        </form>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table><div class="d-flex justify-content-center">
            @if ($orders->currentPage() > 1)
                <a href="{{ $orders->previousPageUrl() }}" class="btn btn-secondary">上一頁</a>
            @endif

            <span class="mx-2">全部 {{ $orders->total() }} 筆資料，目前位於第 {{ $orders->currentPage() }} 頁，共 {{ $orders->lastPage() }} 頁</span>

            @if ($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}" class="btn btn-secondary">下一頁</a>
            @endif
        </div>
    </div> <script>
        function changeRecordsPerPage() {
            const select = document.getElementById('records-per-page');
            const value = select.options[select.selectedIndex].value;
            window.location.href = `{{ route('sellers.orders.index') }}?perPage=${value}`;
        }
    </script>

@endsection
