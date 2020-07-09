@extends('panel.master')

@section('css')

    <link href="{{ asset('assets/global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="page-title">
            <h1>Dashboard</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5>Populasi Per Provinsi</h5>
            <div id="chartprovinsi" style="height: 250px;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5>Populasi Per Kota/Kab</h5>
            <div id="chartkota" style="height: 250px;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5>Populasi Per Kecamatan</h5>
            <div id="chartkecamatan" style="height: 250px;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5>Populasi Per Kelurahan</h5>
            <div id="chartkelurahan" style="height: 250px;"></div>
        </div>
    </div>
</div>

@endsection

@section('myscript')

    <script src="{{ asset('assets/global/plugins/morris/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/morris/morris.min.js') }}"></script>
    <script>   
    Morris.Bar({
        element: 'chartprovinsi',
        data: <?php echo $data['province']; ?>,
        xkey: 'name',
        ykeys: ['population'],
        labels: ['Populasi Per Provinsi']
    });
    Morris.Bar({
        element: 'chartkota',
        data: <?php echo $data['city']; ?>,
        xkey: 'name',
        ykeys: ['population'],
        labels: ['Populasi Per Kota/Kab']
    });
    Morris.Bar({
        element: 'chartkecamatan',
        data: <?php echo $data['district']; ?>,
        xkey: 'name',
        ykeys: ['population'],
        labels: ['Populasi Per Kecamatan']
    });
    Morris.Bar({
        element: 'chartkelurahan',
        data: <?php echo $data['village']; ?>,
        xkey: 'name',
        ykeys: ['population'],
        labels: ['Populasi Per Kelurahan']
    });
    </script>
@endsection