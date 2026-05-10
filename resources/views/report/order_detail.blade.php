<div class="modal-header py-2 text-bg-secondary">
    <h4 class="modal-title" style="font-weight: bold">注文明細</h4>
</div>
<div class="modal-body">
    <table class="table">
        <tbody>
            <tr>
                <td width="80px" style="text-align: right">テーブル：</td>
                <td style="text-align: left">{{ $data->table_name }}</td>
                <td width="80px" style="text-align: right">伝票番号：</td>
                <td style="text-align: left">{{ $data->invoice_no }}</td>
            </tr>
            <tr>
                <td style="width: 60px; text-align: right">レジ担当：</td>
                <td style="text-align: left; width: 100px" class="text-capitalize">{{ $data->cashier }}</td>
                <td style="width: 60px; text-align: right">日時：</td>
                <td style="text-align: left; width: 100px">{{ date('Y/m/d H:i:s',strtotime($data->created_at)) }}</td>
            </tr>
        </tbody>
    </table>
    @php
    $grand_total = 0;
    @endphp
    <table class="table">
        <thead>
            <tr class="table-dark">
                <th>No</th>
                <th>品目</th>
                <th class="text-center">数量</th>
                <th class="text-end">単価 ($)</th>
                <th class="text-end">割引 (%)</th>
                <th class="text-end">小計 ($)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data->order_details as $index=>$value)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $value->description }}</td>
                <td class="text-center">{{ $value->qty }}</td>
                <td class="text-end">{{ number_format($value->unit_price,2)}}</td>
                <td class="text-end">{{ $value->discount }}</td>
                <td class="text-end">
                    {{ number_format($value->unit_price * $value->qty * (1 - $value->discount / 100), 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr />
    <table class="table">
        <tbody>
            @if($data->discount > 0)
            <tr>
                <td style="text-align: right">
                    割引 ({{ $data->discount }}%)：
                </td>
                <td style="text-align: right;">
                    {{ number_format($data->total * $data->discount / 100, 2) }}
                </td>
            </tr>
            @endif
            <tr>
                <th style="text-align: right">合計 ($)：</th>
                <th style="text-align: right; width: 100px;">{{ number_format($data->net_amount,2) }}</th>
            </tr>
            <tr>
                <td style="text-align: right">お預かり ($)：</td>
                <td style="text-align: right">{{ number_format($data->receive_amount,2) }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
        <i class="bi bi-x-lg"></i> 閉じる
    </button>
</div>
