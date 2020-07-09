@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="page-title">
            <h1>IWS Family Tree</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="get" action="{{url('family-tree')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="box-pencarian-family-tree">
                    <div class="row">
                        <div class="col-xl-12 col-md-4 m-b-10px">
                            <label class="form-control-label">Provinsi :</label>
                            <select name="province_id" id="province-selected" class="custom-select form-control">
                                <option value="">Pilih Provinsi</option>
                                @foreach($data['province'] as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12 col-md-4 m-b-10px">
                            <label class="form-control-label">Status Anggota Keluarga :</label>
                            <select name="member_status_id" class="custom-select form-control">
                                <option value="">Pilih Anggota Keluarga</option>
                                @foreach($data['member_status'] as $member_status)
                                    <option value="{{ $member_status->id }}">{{ $member_status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12 col-md-4 m-b-10px">
                            <label class="form-control-label">Status Pernikahan :</label>
                            <select name="marital_id" class="custom-select form-control">
                                <option value="">Pilih Status Pernikahan</option>
                                @foreach($data['marital'] as $marital)
                                    <option value="{{ $marital->id }}">{{ $marital->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-md-4 m-b-10px">
                            <label class="form-control-label">Kota :</label>
                            <select name="city_id" id="city-selected" class="custom-select form-control" disabled>
                                <option value="">Pilih Kota / Kabupaten</option>
                            </select>
                        </div>
                        <div class="col-xl-12 col-md-4 m-b-10px">
                            <label class="form-control-label">Suku :</label>
                            <select name="ethnic_id" class="custom-select form-control">
                                <option value="">Pilih Suku</option>
                                @foreach($data['ethnic'] as $ethnic)
                                    <option value="{{ $ethnic->id }}">{{ $ethnic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12 col-md-4 m-b-10px">
                            <label class="form-control-label">Status Keberadaan :</label>
                            <select name="is_life" class="custom-select form-control">
                                <option value="">Pilih Keberadaan</option>
                                <option value="1">Hidup</option>
                                <option value="0">Meninggal</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-md-4 m-b-10px">
                            <label class="form-control-label">Gelar Adat :</label>
                            <select name="title_adat_id" class="custom-select form-control">
                                <option value="">Pilih Adat</option>
                                @foreach($data['title_adat'] as $title_adat)
                                    <option value="{{ $title_adat->id }}">{{ $title_adat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12 col-md-4 m-b-10px">
                            <label class="form-control-label">Jenis Pekerjaan :</label>
                            <select name="job_id" class="custom-select form-control">
                                <option value="">Pilih Pekerjaan</option>
                                @foreach($data['job'] as $job)
                                    <option value="{{ $job->id }}">{{ $job->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12 col-md-4 m-b-10px">
                            <br><button type="submit" name="submit" value="search" id="search-button" class="btn btn-primary">Search <i class="icon-refresh"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive custom--2">
                <table id="sorting-table" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Status Anggota</th>
                            <th>Domisili</th>
                            <th>Suku</th>
                            <th>Gelar</th>
                            <th>Pekerjaan</th>
                            <th>Pernikahan</th>
                            <th>Keberadaan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data['member'] as $member)
                        <tr>
                            <td>{{ $member->no }}</td>
                            <td>{{ $member->full_name }}</td>
                            <td>{{ $member->member_status->name }}</td>
                            <td>{{ $member->city->name }}</td>
                            <td>{{ isset($member->ethnic) ? $member->ethnic->name : '-' }}</td>
                            <td>{{ isset($member->title_adat) ? $member->title_adat->name : '-' }}</td>
                            <td>{{ isset($member->job) ? $member->job->name : '-' }}</td>
                            <td>{{ $member->marital->name }}</td>
                            <td>Hidup</td>
                            <td class="text-center">
                                <a href="{{ url('family-tree-detail/'.$member->id) }}"><i class="fa fa-eye fa-lg custom--1"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="userAccessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal Akses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @if(session()->has('access_message'))
      <div class="modal-body">
        {{ session()->get('access_message') }}
      </div>
      @endif
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('myscript')

    <script src="{{ asset('assets/global/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}"></script>
    @if(session()->has('access_message'))
    <script>
        $(function() {
            $('#userAccessModal').modal('show');
        });
    </script>
    @endif
    
    <script>   
    $(function () {
        $('#province-selected').on('change', function() {
            $('#city-selected').empty().append('<option value="">Pilih Kota</option>');
            $.ajax({
                url: "master/district/get-list-city/"+this.value,
                method: 'get',
                success : function(data) {
                    var parse_data = JSON.parse(data);
                    if(parse_data.length > 0) {
                        $('#city-selected').prop('disabled', false);
                        for(var index in parse_data) {
                            $("#city-selected").append('<option value="'+ parse_data[index].id +'">'+ parse_data[index].name +'</option>');
                        }
                    } else {
                        $('#city-selected').prop('disabled', true);
                    }
                },
                error : function(err){
                    $('#city-selected').prop('disabled', true);
                }
            });
        });
        // $("select").select2();
        $('#sorting-table').DataTable( {
            "dom": '<"toolbar">frtip',
            "ordering": false,
            "info":     false,
            "pageLength": 20,
            language: { search: "", searchPlaceholder: "Nama Member"  },
        } );
        // $("div.toolbar").html('<a class="float-right btn btn-success" href="#">Sembunyikan Detail</a>');
    });
    </script>
@endsection