@extends('pdf.master', [
    'doc_title' => 'I N V O I C E',
    'doc_no' => "#{$record->code}",
])

@section('content')
    <table width="100%" cellpadding="10" cellspacing="10" class="table-noborder table-lg">
        <tbody>
            <tr class="bg-primary text-bold">
                <td width="60%">BILL TO</td>
                <td>INVOICE</td>
            </tr>
            <tr>
                <td valign="top">
                    <div><b>{{ $record->name }}</b></div>
                    <div>{{ $record->customer->address }}</div>
                </td>
                <td valign="top">
                    <div>
                        <div class="float-right">{{ $record->code }}</div>
                        <div>No</div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="float-right">{{ $record->order_date->format('d M Y') }}</div>
                        <div>Date</div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="float-right">{{ $record->terapis->name }}</div>
                        <div>Terapis</div>
                        <div class="clearfix"></div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <br />
    <br />
    <table width="100%" cellpadding="10" cellspacing="10" class="table-bordered">
        <thead>
            <tr class="bg-primary text-bold">
                <td>Item</td>
                <td width="40px">Qty</td>
                <td width="80px">Price</td>
                <td width="120px">Total</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($record->packages as $item)
                <tr>
                    <td>
                        <div>{{ $item->package->name }} - {{ $item->package->duration }} menit</div>
                        <div><i class="text-gray text-sm">{{ $item->package->items->pluck('item.name')->implode(',') }}</i>
                        </div>
                    </td>
                    <td align="right">{{ $item->qty }}</td>
                    <td align="right">{{ number_format($item->price) }}</td>
                    <td align="right">{{ number_format($item->total) }}</td>
                </tr>
            @endforeach
            @foreach ($record->items as $item)
                <tr>
                    <td>
                        <div>{{ $item->item->name }} - {{ $item->item->duration }} menit</div>
                    </td>
                    <td align="right">{{ $item->qty }}</td>
                    <td align="right">{{ number_format($item->price) }}</td>
                    <td align="right">{{ number_format($item->total) }}</td>
                </tr>
            @endforeach
            <tr class="text-bold text-right bg-gray">
                <td colspan="3">Transport</td>
                <td>{{ number_format($record->transport) }}</td>
            </tr>
            <tr class="text-bold text-right bg-gray">
                <td colspan="3">Grand Total</td>
                <td>{{ number_format($record->invoice_total) }}</td>
            </tr>
        </tbody>
    </table>
    <br />
    <br />
    <b>*Notes:</b>
    <ul>
        <li>
            Invoice ini merupakan faktur tagihan sekaligus bukti pembayaran yang sah, dan diterbitkan oleh Jemari Home Spa
        </li>
        <li>Pembayaran bisa diberikan langsung kepada terapis kami (tunai) atau transfer melalui salah satu rekening berikut:
            <ul>
                @foreach ($record->customer->site->activeBanks as $bank)
                    <li><b>{{ $bank->bankType->name }}: {{ $bank->bank_no }}</b> An. {{ $bank->name }} </li>
                @endforeach
            </ul>
        </li>
        <li>Harap mengirimkan bukti transfer kepada admin melalui whatsapp setelah melakukan pembayaran</li>
    </ul>
    <p>
    @stop
