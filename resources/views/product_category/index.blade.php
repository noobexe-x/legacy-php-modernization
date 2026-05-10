<!-- Laravel POS With jQuery @ https://laravelcenter.com -->
<button type="button" class="btn btn-primary" style="float: right"
    onclick="ajaxPopup(`{{ url('product-category/form') }}`)">
    <i class="bi bi-plus-circle"></i> 新規追加
</button>

<div class="pagetitle">
    <h1>商品カテゴリ</h1>
</div>
<section class="section">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form method="get" id="search_form" action="{{ url('/product-category') }}">
                    <div class="row pt-4">
                        <div class="col-md-10">
                            <div class="row justify-content-start">
                                <div class="col-lg-3 col-sm-6">
                                    <label class="form-label" for="product_category_name">名前</label>
                                    <input type="text" id="product_category_name" name="product_category_name"
                                        class="form-control" value="{{ session('product_category_name') }}"
                                        placeholder="検索…" />
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
                                onclick="ajaxLoad(`{{ url('product-category?product_category_field=name&product_category_order=' . (session('product_category_order') == 'asc' ? 'desc' : 'asc')) }}`)">
                                名前
                                <i
                                    class="text-secondary {{ session('product_category_field') == 'name' ? (session('product_category_order') == 'desc' ? 'bi bi-sort-alpha-down-alt' : 'bi bi-sort-alpha-down') : 'bi bi-arrow-down-up' }}"></i>
                            </th>
                            <th style="cursor: pointer; width: 200px;"
                                onclick="ajaxLoad(`{{ url('product-category?product_category_field=created_at&product_category_order=' . (session('product_category_order') == 'asc' ? 'desc' : 'asc')) }}`)">
                                作成日時
                                <i
                                    class="text-secondary {{ session('product_category_field') == 'created_at' ? (session('product_category_order') == 'desc' ? 'bi bi-sort-alpha-down-alt' : 'bi bi-sort-alpha-down') : 'bi bi-arrow-down-up' }}"></i>
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
                            <td style="vertical-align: middle">
                                {{ date('Y/m/d H:i:s', strtotime($value->created_at)) }}
                            </td>
                            <td style="vertical-align: middle;text-align: center;">
                                <i class="bi bi-trash3-fill text-danger" role="button"
                                    data-record-url="{{ url('product-category/delete') }}"
                                    data-record-id="{{ $value->id }}" title="削除"
                                    data-bs-toggle="modal" data-bs-target="#confirmDelete"></i>
                                <a title="編集"
                                    href="javascript:ajaxPopup('{{ url('product-category/form/' . $value->id) }}')">
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