<!-- Laravel POS With jQuery @ https://laravelcenter.com -->
<button type="button" class="btn btn-primary" style="float: right" onclick="ajaxPopup(`{{ url('balance-adjustment/form') }}`)">
    <i class="bi bi-plus-circle"></i> 新規追加
</button>

<div class="pagetitle">
    <h1>残高調整</h1>
</div>
<section class="section">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form method="get" id="search_form" action="{{ url('/balance-adjustment') }}">
                    <div class="row pt-4">
                        <div class="col-md-10">
                            <div class="row justify-content-start">
                                <div class="col-lg-3 col-sm-6">
                                    <label class="form-label" for="balance_adjustment_remark">備考</label>
                                    <input type="text" id="balance_adjustment_remark" name="balance_adjustment_remark" class="form-control"
                                        value="{{ session('balance_adjustment_remark') }}" placeholder="検索…" />
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label for="balance_adjustment_type_id" class="form-label">種別</label>
                                    <select id="balance_adjustment_type_id" name="balance_adjustment_type_id" class="form-select">
                                        <option value="0"
                                            {{ session('balance_adjustment_type_id') == 0 ? 'selected' : '' }}>
                                            すべて
                                        </option>
                                        <option value="1"
                                            {{ session('balance_adjustment_type_id') == 1 ? 'selected' : '' }}>
                                            入金 (+)
                                        </option>
                                        <option value="2"
                                            {{ session('balance_adjustment_type_id') == 2 ? 'selected' : '' }}>
                                            出金 (-)
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label class="form-label" for="balance_adjustment_fd">開始日</label>
                                    <input type="text" id="balance_adjustment_fd" name="balance_adjustment_fd" value="{{session('balance_adjustment_fd')}}" class="form-control" />
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label class="form-label" for="balance_adjustment_td">終了日</label>
                                    <input type="text" id="balance_adjustment_td" name="balance_adjustment_td" value="{{session('balance_adjustment_td')}}" class="form-control" />
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
                <table class="table table-striped">
                    <thead>
                        <tr class="table-dark">
                            <th width="50px">#</th>
                            <th class="text-end" style="cursor: pointer"
                                onclick="ajaxLoad(`{{ url('balance-adjustment?balance_adjustment_field=amount&balance_adjustment_order=' . (session('balance_adjustment_order') == 'asc' ? 'desc' : 'asc')) }}`)">
                                金額
                                <i
                                    class="text-secondary {{ session('balance_adjustment_field') == 'amount' ? (session('balance_adjustment_order') == 'desc' ? 'bi bi-sort-alpha-down-alt' : 'bi bi-sort-alpha-down') : 'bi bi-arrow-down-up' }}"></i>
                            </th>
                            <th style="cursor: pointer"
                                onclick="ajaxLoad(`{{ url('balance-adjustment?balance_adjustment_field=type_id&balance_adjustment_order=' . (session('balance_adjustment_order') == 'asc' ? 'desc' : 'asc')) }}`)">
                                種別
                                <i
                                    class="text-secondary {{ session('balance_adjustment_field') == 'type_id' ? (session('balance_adjustment_order') == 'desc' ? 'bi bi-sort-alpha-down-alt' : 'bi bi-sort-alpha-down') : 'bi bi-arrow-down-up' }}"></i>
                            </th>
                            <th> 備考 </th>
                            <th style="cursor: pointer"
                                onclick="ajaxLoad(`{{ url('balance-adjustment?balance_adjustment_field=adjusted_date&balance_adjustment_order=' . (session('balance_adjustment_order') == 'asc' ? 'desc' : 'asc')) }}`)">
                                調整日
                                <i
                                    class="text-secondary {{ session('balance_adjustment_field') == 'adjusted_date' ? (session('balance_adjustment_order') == 'desc' ? 'bi bi-sort-alpha-down-alt' : 'bi bi-sort-alpha-down') : 'bi bi-arrow-down-up' }}"></i>
                            </th>
                            <th style="cursor: pointer"
                                onclick="ajaxLoad(`{{ url('balance-adjustment?balance_adjustment_field=updated_at&balance_adjustment_order=' . (session('balance_adjustment_order') == 'asc' ? 'desc' : 'asc')) }}`)">
                                更新日時
                                <i
                                    class="text-secondary {{ session('balance_adjustment_field') == 'updated_at' ? (session('balance_adjustment_order') == 'desc' ? 'bi bi-sort-alpha-down-alt' : 'bi bi-sort-alpha-down') : 'bi bi-arrow-down-up' }}"></i>
                            </th>
                            <th class="text-center" width="100px">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($list) && count($list) > 0)
                        @foreach ($list as $index => $value)
                        <tr>
                            <th style="vertical-align: middle;text-align: center">
                                {{ $list->perPage() * ($list->currentPage() - 1) + ($index + 1) }}
                            </th>
                            <td style="vertical-align: middle" class="text-end">${{ number_format($value->amount, 2) }}</td>
                            <td style="vertical-align: middle">{{ $value->type_id == 1?'入金 (+)':'出金 (-)' }}</td>
                            <td style="vertical-align: middle">{{ $value->remark }}</td>
                            <td style="vertical-align: middle">
                                {{ date('Y/m/d', strtotime($value->adjusted_date)) }}
                            </td>
                            <td style="vertical-align: middle">
                                {{ date('Y/m/d H:i:s', strtotime($value->updated_at)) }}
                            </td>
                            <td style="vertical-align: middle;text-align: center;">
                                <i class="bi bi-trash3-fill text-danger" role="button"
                                    data-record-url="{{ url('balance-adjustment/delete') }}"
                                    data-record-id="{{ $value->id }}" title="削除"
                                    data-bs-toggle="modal" data-bs-target="#confirmDelete"></i>
                                <a title="編集"
                                    href="javascript:ajaxPopup('{{ url('balance-adjustment/form/' . $value->id) }}')">
                                    <i class="bi bi-pencil-square text-success ps-3" role="button"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr v-else>
                            <td colspan="10" class="shadow-none">
                                データがありません
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <!-- Pagination -->
                    <nav>
                        <ul class="pagination justify-content-end">
                            {{ $list->links()}}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        const $start = $("#balance_adjustment_fd");
        const $end = $("#balance_adjustment_td");

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