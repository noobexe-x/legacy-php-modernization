<!-- Laravel POS With jQuery @ https://laravelcenter.com -->
<button type="button" class="btn btn-primary" style="float: right" onclick="ajaxPopup(`{{ url('table/form') }}`)">
    <i class="bi bi-plus-circle"></i> 新規追加
</button>

<div class="pagetitle">
    <h1>テーブル</h1>
</div>
<section class="section">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form method="get" id="search_form" action="{{ url('/table') }}">
                    <div class="row pt-4">
                        <div class="col-md-10">
                            <div class="row justify-content-start">
                                <div class="col-lg-3 col-sm-6">
                                    <label class="form-label" for="table_name">名前</label>
                                    <input type="text" id="table_name" name="table_name" class="form-control"
                                        value="{{ session('table_name') }}" placeholder="検索…" />
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label for="table_status" class="form-label">ステータス</label>
                                    <select id="table_status" name="table_status" class="form-select">
                                        <option value="0" {{ session('table_status') == 0 ? 'selected' : '' }}>
                                            すべて
                                        </option>
                                        <option value="2" {{ session('table_status') == 2 ? 'selected' : '' }}>
                                            空席</option>
                                        <option value="1" {{ session('table_status') == 1 ? 'selected' : '' }}>
                                            使用中</option>
                                        <option value="3" {{ session('table_status') == 3 ? 'selected' : '' }}>
                                            会計中</option>
                                    </select>
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
                            <th style="cursor: pointer"
                                onclick="ajaxLoad(`{{ url('table?table_field=name&table_order=' . (session('table_order') == 'asc' ? 'desc' : 'asc')) }}`)">
                                名前
                                <i
                                    class="text-secondary {{ session('table_field') == 'name' ? (session('table_order') == 'desc' ? 'bi bi-sort-alpha-down-alt' : 'bi bi-sort-alpha-down') : 'bi bi-arrow-down-up' }}"></i>
                            </th>
                            <th style="cursor: pointer"
                                onclick="ajaxLoad(`{{ url('table?table_field=status&table_order=' . (session('table_order') == 'asc' ? 'desc' : 'asc')) }}`)">
                                ステータス
                                <i
                                    class="text-secondary {{ session('table_field') == 'status' ? (session('table_order') == 'desc' ? 'bi bi-sort-alpha-down-alt' : 'bi bi-sort-alpha-down') : 'bi bi-arrow-down-up' }}"></i>
                            </th>
                            <th style="cursor: pointer"
                                onclick="ajaxLoad(`{{ url('table?table_field=created_at&table_order=' . (session('table_order') == 'asc' ? 'desc' : 'asc')) }}`)">
                                作成日時
                                <i
                                    class="text-secondary {{ session('table_field') == 'created_at' ? (session('table_order') == 'desc' ? 'bi bi-sort-alpha-down-alt' : 'bi bi-sort-alpha-down') : 'bi bi-arrow-down-up' }}"></i>
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
                            <td style="vertical-align: middle">{{ $value->name }}</td>
                            <td style="vertical-align: middle">{!! $value->status == 1
                                ? '<span class="text-danger">使用中</span>'
                                : ($value->status == 2
                                ? '空席'
                                : '<span class="text-danger">印刷済み</span>') !!}</td>
                            <td style="vertical-align: middle">
                                {{ date('Y/m/d H:i:s', strtotime($value->created_at)) }}
                            </td>
                            <td style="vertical-align: middle;text-align: center;">
                                <i class="bi bi-trash3-fill text-danger" role="button"
                                    data-record-url="{{ url('table/delete') }}"
                                    data-record-id="{{ $value->id }}" title="削除"
                                    data-bs-toggle="modal" data-bs-target="#confirmDelete"></i>
                                <a title="編集"
                                    href="javascript:ajaxPopup('{{ url('table/form/' . $value->id) }}')">
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
                            {{ $list->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>