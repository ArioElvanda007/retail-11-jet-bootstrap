<!-- title row -->
<div class="row px-2">
    <div class="col-12">
        <div class="row">
            <div class="d-flex flex-column">
                <div class="text-center">{{ $buss->name }}</div>
                <div class="text-center mb-0">{{ $buss->address }}</div>
                <div class="text-center mb-2 border-bottom">WhatsApp: {{ $buss->telephone }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row px-2">
    <div class="col-12">
        <div class="row">
            <div class="col-4">
                Invoice
            </div>
            <div class="col-1">
                :
            </div>
            <div class="col-7">
                {{ $query->code }}
            </div>
        </div>

        @if ($query->$party->id == 1)
            <div class="row border-bottom">
                <div class="col-4">
                    Date
                </div>
                <div class="col-1">
                    :
                </div>
                <div class="col-7">
                    {{ date('d-M-Y', strtotime($query->date_input)) }}
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-4">
                    Date
                </div>
                <div class="col-1">
                    :
                </div>
                <div class="col-7">
                    {{ date('d-M-Y', strtotime($query->date_input)) }}
                </div>
            </div>
        @endif        

        <div class="row"
            @if ($query->$party->id == 1)
                hidden
            @endif
        >
            <div class="col-4">
                {{ $party_name }}
            </div>
            <div class="col-1">
                :
            </div>
            <div class="col-7">
                {{ $query->$party->name }}
            </div>
        </div>

        @if ($query->$party->id != 1)
            @if ($query->$party->address)
                <div class="row mb-2 border-bottom">
                    <div class="col-4">
                        
                    </div>
                    <div class="col-1">
                        
                    </div>
                    <div class="col-7">
                        {{ $query->$party->address }}, Telp : {{ $query->$party->telephone }}
                    </div>                
                </div>
            @else
                <div class="row mb-2 border-bottom">
                    <div class="col-4">
                        Telp
                    </div>
                    <div class="col-1">
                        :
                    </div>
                    <div class="col-7">
                        {{ $query->$party->telephone }}
                    </div>                
                </div>        
            @endif
        @endif
    </div>
</div>
<!-- /.row -->
