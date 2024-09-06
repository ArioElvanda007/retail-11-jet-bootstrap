<!-- Table row -->
<div class="row">
    <div class="col-12 table-responsive">
        <table class="table table-sm table-borderless">
            <thead class="border-bottom">
                <tr>
                    <th>Product</th>
                    <th class="text-end">Rate</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($query->$detail as $data)
                <tr>
                    <td>{{ $data->products->name }}</td>
                    <td class="text-end">{{ number_format($data->rate, 0, '.', ',') }}</td>
                    <td class="text-end">{{ number_format(($data->rate * $data->amount) - $data->discount, 0, '.', ',') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-top border-bottom">
                    <td>Total</td>
                    <td class="text-end">{{ number_format($query->rate, 0, '.', ',') }}</td>
                    <td class="text-end">{{ number_format($query->subtotal, 0, '.', ',') }}</td>
                </tr>

                <tr
                    @if ($query->discount == 0)
                        hidden
                    @endif
                >
                    <td></td>
                    <td class="text-end">Disc :</td>
                    <td class="text-end">{{ number_format($query->discount, 0, '.', ',') }}</td>
                </tr>
                <tr
                    @if ($query->discount == 0)
                        hidden
                    @endif                
                >
                    <td></td>
                    <td class="text-end">Total :</td>
                    <td class="text-end">{{ number_format($query->subtotal - $query->discount, 0, '.', ',') }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-end">Pay :</td>
                    <td class="text-end">{{ number_format($query->pay, 0, '.', ',') }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-end">Return :</td>
                    <td class="text-end">{{ number_format($query->pay - ($query->subtotal - $query->discount), 0, '.', ',') }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-end">Method :</td>
                    <td class="text-end">
                        @if ($query->bank_id == 0)
                            On Hand
                        @else
                            {{ $query->banks->account_name }}
                        @endif
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- /.col -->
</div>
<!-- /.row -->
