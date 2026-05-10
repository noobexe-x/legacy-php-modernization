    {{-- Laravel jQuery POS Sales Reports @ https://laravelcenter.com --}}
    <div class="pagetitle">
        <h1>売上サマリー</h1>
    </div>
    <section class="section">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="get" id="search_form" action="{{ url('/report/sale-summary') }}">
                        <div class="row pt-4">
                            <div class="col-md-10">
                                <div class="row justify-content-start">
                                    <div class="col-lg-3 col-sm-6">
                                        <label class="form-label" for="sale_summary_fd">開始日</label>
                                        <input type="text" id="sale_summary_fd" name="sale_summary_fd"
                                            value="{{ session('sale_summary_fd') }}" class="form-control" />
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <label class="form-label" for="sale_summary_td">終了日</label>
                                        <input type="text" id="sale_summary_td" name="sale_summary_td"
                                            value="{{ session('sale_summary_td') }}" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 align-self-end">
                                <button type="submit" class="btn btn-secondary pt-1" style="float: right">
                                    <i class="bi bi-search"></i> 検索
                                </button>
                            </div>
                        </div>
                    </form>
                    <hr class="text-secondary" />
                    @php
                        $total_amount = 0;
                        $total_discount = 0;
                        $net_amount = 0;
                        foreach ($list as $value) {
                            $total_amount += $value->total;
                            $total_discount += $value->discount;
                        }
                        $net_amount = $total_amount - $total_discount;
                    @endphp
                    <table class="table shadow mb-4">
                        <thead>
                            <tr class="table-dark">
                                <th class="text-center">
                                    売上合計
                                </th>
                                <th class="text-center">
                                    値引合計
                                </th>
                                <th class="text-center">
                                    純売上
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="fs-4">
                                <th class="text-center text-primary">
                                    $ {{ number_format($total_amount, 2) }}
                                </th>
                                <th class="text-center text-danger">
                                    $ {{ number_format($total_discount, 2) }}
                                </th>
                                <th class="text-center text-success">
                                    $ {{ number_format($net_amount, 2) }}
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table shadow">
                        <thead>
                            <tr class="table-dark">
                                <th>商品カテゴリ</th>
                                <th class="text-end" width="300px">売上合計</th>
                                <th class="text-end" width="300px">値引合計</th>
                                <th class="text-end" width="300px">純売上</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($list->count() > 0)
                                @foreach ($list as $value)
                                    <tr>
                                        <td>{{ $value->name }}</td>
                                        <td class="text-end">$ {{ number_format($value->total, 2) }}</td>
                                        <td class="text-end">$ {{ number_format($value->discount, 2) }}</td>
                                        <td class="text-end">$ {{ number_format($value->total - $value->discount, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="shadow-none">
                                        データがありません
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            const $start = $("#sale_summary_fd");
            const $end = $("#sale_summary_td");

            const startPicker = flatpickr($start, {
                altFormat: "Y/m/d",
                altInput: true,
                onChange: function(selectedDates, dateStr, instance) {
                    if (dateStr) {
                        endPicker.set('minDate', dateStr);
                    }
                }
            });

            const endPicker = flatpickr($end, {
                altFormat: "Y/m/d",
                altInput: true,
                onChange: function(selectedDates, dateStr, instance) {
                    if (dateStr) {
                        startPicker.set('maxDate', dateStr);
                    }
                }
            });
        });
    </script>
