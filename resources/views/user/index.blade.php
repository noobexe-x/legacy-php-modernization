<!-- Laravel POS With jQuery @ https://laravelcenter.com -->
<button type="button" class="btn btn-primary" style="float: right" onclick="ajaxPopup(`{{ url('user/form') }}`)">
    <i class="bi bi-plus-circle"></i> 新規追加
</button>

<div class="pagetitle">
    <h1>ユーザー</h1>
</div>
<section class="section">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form method="get" id="search_form" action="{{ url('/user') }}">
                    <div class="row pt-4">
                        <div class="col-md-10">
                            <div class="row justify-content-start">
                                <div class="col-lg-3 col-sm-6">
                                    <label class="form-label" for="user_name">名前</label>
                                    <input type="text" id="user_name" name="user_name" class="form-control"
                                        value="{{ session('user_name') }}" placeholder="検索…" />
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label for="user_role" class="form-label">役割</label>
                                    <select id="user_role" name="user_role" class="form-select">
                                        <option value="0" {{ session('user_role') == 0 ? 'selected' : '' }}>
                                            すべて
                                        </option>
                                        <option value="superadmin" {{ session('user_role') == 'superadmin' ? 'selected' : '' }}>
                                            スーパー管理者
                                        </option>
                                        <option value="admin" {{ session('user_role') == 'admin' ? 'selected' : '' }}>
                                            管理者
                                        </option>
                                        <option value="cashier" {{ session('user_role') == 'cashier' ? 'selected' : '' }}>
                                            レジ
                                        </option>
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
                                onclick="ajaxLoad(`{{ url('user?user_field=username&user_order=' . (session('user_order') == 'asc' ? 'desc' : 'asc')) }}`)">
                                ユーザー名
                                <i class="text-secondary {{ session('user_field') == 'username' ? (session('user_order') == 'desc' ? 'bi bi-sort-alpha-down-alt' : 'bi bi-sort-alpha-down') : 'bi bi-arrow-down-up' }}"></i>
                            </th>
                            <th style="cursor: pointer"
                                onclick="ajaxLoad(`{{ url('user?user_field=role&user_order=' . (session('user_order') == 'asc' ? 'desc' : 'asc')) }}`)">
                                役割
                                <i class="text-secondary {{ session('user_field') == 'role' ? (session('user_order') == 'desc' ? 'bi bi-sort-alpha-down-alt' : 'bi bi-sort-alpha-down') : 'bi bi-arrow-down-up' }}"></i>
                            </th>
                            <th style="cursor: pointer"
                                onclick="ajaxLoad(`{{ url('user?user_field=active&user_order=' . (session('user_order') == 'asc' ? 'desc' : 'asc')) }}`)">
                                有効
                                <i class="text-secondary {{ session('user_field') == 'active' ? (session('user_order') == 'desc' ? 'bi bi-sort-alpha-down-alt' : 'bi bi-sort-alpha-down') : 'bi bi-arrow-down-up' }}"></i>
                            </th>
                            <th style="cursor: pointer"
                                onclick="ajaxLoad(`{{ url('user?user_field=created_at&user_order=' . (session('user_order') == 'asc' ? 'desc' : 'asc')) }}`)">
                                作成日時
                                <i class="text-secondary {{ session('user_field') == 'created_at' ? (session('user_order') == 'desc' ? 'bi bi-sort-alpha-down-alt' : 'bi bi-sort-alpha-down') : 'bi bi-arrow-down-up' }}"></i>
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
                            <td style="vertical-align: middle">{{ $value->username }}</td>
                            <td style="vertical-align: middle">{{ match ($value->role) {
                                'superadmin' => 'スーパー管理者',
                                'admin' => '管理者',
                                'cashier' => 'レジ',
                                default => $value->role,
                            } }}
                            </td>
                            <td class="py-0 my-0">
                                <i class="bi {{$value->active?'bi-toggle-on text-success':'bi-toggle-off text-danger'}} fs-3"></i>
                            </td>
                            <td style="vertical-align: middle">
                                {{ date('Y/m/d H:i:s', strtotime($value->created_at)) }}
                            </td>
                            <td style="vertical-align: middle;text-align: center;">
                                <i class="bi bi-trash3-fill text-danger" role="button"
                                    data-record-url="{{ url('user/delete') }}"
                                    data-record-id="{{ $value->id }}" title="削除"
                                    data-bs-toggle="modal" data-bs-target="#confirmDelete"></i>
                                <a title="編集"
                                    href="javascript:ajaxPopup('{{ url('user/form/' . $value->id) }}')">
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