<div style="text-align: center;">
    <img src="{{ url('./images/sourkea.png') }}" height="100px" width="250px" />
    <i style="font-size: 11px; display: block">
        住所: #111, Steet 999, Somroung Teav, Sen Sok, Phnom Penh. TEL: 089456111, 098456111
    </i>
    <h1 style="padding: 0px; margin: 0px; font-size: 30px">レシート</h1>
</div>
<hr style="margin-top: 0px; padding-top: 0px" />
<table style="width: 100%; font-size: 12px">
    <thead>
        <tr>
            <td width="80px" style="text-align: right">テーブル：</td>
            <td style="text-align: left">{{ $order->table?->name }}</td>
            <td width="80px" style="text-align: right">伝票番号：</td>
            <td style="text-align: left">{{ $order->invoice_no }}</td>
        </tr>
        <tr>
            <td style="width: 60px; text-align: right">レジ担当：</td>
            <td style="text-align: left; width: 100px">{{ $order->createdBy?->username }}</td>
            <td style="width: 60px; text-align: right">日時：</td>
            <td style="text-align: left; width: 100px">{{ date('Y/m/d H:i:s', strtotime($order->created_at)) }}</td>
        </tr>
    </thead>
</table>
<table style="width: 100%; margin-top: 10px" border="0" cellspacing="0" cellpadding="2px">
    <thead>
        <tr style="background: darkgray">
            <th width="20px">No</th>
            <th style="text-align: left">品目</th>
            <th style="width: 8%; text-align: center">数量</th>
            <th style="width: 16%; text-align: right">単価 ($)</th>
            <th style="width: 12%; text-align: right">割引 (%)</th>
            <th style="width: 18%; text-align: right">小計 ($)
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->order_details as $index => $value)
            <tr style="font-size: 11px">
                <td align="center">{{ $index + 1 }}</td>
                <td align="left">{{ $value->description }}</td>
                <td align="center">{{ $value->qty }}</td>
                <td align="right">{{ number_format($value->unit_price, 2) }}</td>
                <td align="right">{{ $value->discount }}</td>
                <td align="right">
                    {{ number_format($value->unit_price * $value->qty * (1 - $value->discount / 100), 2) }} </td>
            </tr>
        @endforeach
    </tbody>
</table>
<hr />
<table style="font-size: 14px; width: 100%;">
    <tbody>
        @if ($order->discount > 0)
            <tr>
                <td style="text-align: right">
                    割引 ({{ $order->discount }}%)：
                </td>
                <td style="text-align: right;">
                    {{ number_format(($order->total * $order->discount) / 100, 2) }}
                </td>
            </tr>
        @endif
        <tr>
            <th style="text-align: right">合計 ($)：</th>
            <th style="text-align: right; width: 100px;">{{ number_format($order->net_amount, 2) }}</th>
        </tr>
        <tr>
            <td style="text-align: right">お預かり ($)：</td>
            <td style="text-align: right; width: 100px;">{{ number_format($order->receive_amount, 2) }}</td>
        </tr>
        <tr>
            <td style="text-align: right">おつり ($)：</td>
            <td style="text-align: right; width: 100px;">
                {{ number_format($order->receive_amount - $order->net_amount, 2) }}</td>
        </tr>
    </tbody>
</table>
<hr />
<div style="text-align: center">
    <i style="font-size: 12px">ありがとうございました。またのご来店をお待ちしております。</i><br />
</div>
