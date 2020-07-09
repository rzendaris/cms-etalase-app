@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="page-title">
            <h1>Perbarui Data Keluarga</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 element">
            <form method="post" action="{{url('family-management/update')}}" enctype="multipart/form-data">
            {{csrf_field()}}
                <div class="box-pencarian-family-tree" style=" background: #fff; ">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 m-b-10px">
                            <div class="form-group">
                                <label class="form-control-label">No KK :*</label>
                                <input type="text" name="family_no" value="{{ $data['family']->family_no }}" class="form-control" required/>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Kota / Kabupaten :*</label>
                                <select name="city_id" id="city-selected" class="custom-select form-control" required>
                                    <option value="{{ $data['family']->city->id }}">{{ $data['family']->city->name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Kode POS :*</label>
                                <input type="text" name="post_code" value="{{ $data['family']->post_code }}" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">No Telp :</label>
                                <input type="text" name="tlp_no" value="{{ $data['family']->tlp_no }}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 m-b-10px">
                            <div class="form-group">
                                <label class="form-control-label">No KK Induk :</label>
                                <input type="text" name="inherit_no" value="{{ $data['family']->inherit_no }}" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Kecamatan :*</label>
                                <select name="district_id" id="district-selected" class="custom-select form-control" required>
                                    <option value="{{ $data['family']->district->id }}">{{ $data['family']->district->name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Alamat :*</label>
                                <textarea type="text" name="address" class="form-control" rows="5" required>{{ $data['family']->address }}</textarea>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 m-b-10px">
                            <div class="form-group">
                                <label class="form-control-label">Provinsi :*</label>
                                <select name="province_id" id="province-selected" class="custom-select form-control" required>
                                    <option value="{{ $data['family']->province->id }}">{{ $data['family']->province->name }}</option>
                                    @foreach($data['province'] as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Kelurahan / Desa :*</label>
                                <select name="village_id" id="village-selected" class="custom-select form-control" required>
                                    <option value="{{ $data['family']->village->id }}">{{ $data['family']->village->name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Foto Keluarga :</label><br>
                                <img id="blah2" alt="your image" width="90" height="90"  src="{{ url('photo/kk/'.$data['family']->photo) }}" onerror="this.src='{{ url('assets/global/img/no-profile.jpg') }}'"/><br>
                                <input id="upload-img-2" name="photo" type="file" onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                            <input type="hidden" name="id" value="{{ $data['family']->id }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 m-b-10px text-right">
                            <input type="hidden" name="family_id" value="{{ $data['family']->id }}"/>
                            <a href="{{ url('family-management') }}" class="btn btn-primary pull-left">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <br>

        <div class="page-head">
            <div class="page-title">
                <h1>Detail Data Anggota Keluarga</h1>
            </div>
        </div><br>
        @foreach($data['family']->member as $member)
            @if(isset($member))
                <div class="col-md-12 element">
                    <div class="box-pencarian-family-tree" style=" background: #fff; ">
                        <div class="row">
                            <div class="col-xl-4 col-md-4 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">NIK :</label>
                                    <input type="text" value="{{ $member->nik }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Tanggal Lahir :</label>
                                    <input type="date" value="{{ $member->birthday }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Kecamatan :</label>
                                    <input type="text" value="{{ $member->district->name }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Jenis Pekerjaan :</label>
                                    <input type="text" value="{{ isset($member->job) ? $member->job->name : '-' }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Pendidikan Terakhir :</label>
                                    <input type="text" value="{{ isset($member->education) ? $member->education->name : '-' }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Suku :</label>
                                    <input type="text" value="{{ isset($member->ethnic) ? $member->ethnic->name : '-' }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Alamat :</label>
                                    <textarea type="text" name="address" class="form-control" rows="5" disabled required>{{ $member->address }}</textarea>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Nama Lengkap :</label>
                                    <input type="text" value="{{ $member->full_name }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Provinsi :</label>
                                    <input type="text" value="{{ $member->province->name }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Kelurahan / Desa :</label>
                                    <input type="text" value="{{ $member->village->name }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Nama Instansi/Usaha :</label>
                                    <input type="text" value="{{ $member->instance_name }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Nama Sekolah :</label>
                                    <input type="text" value="{{ $member->school_name }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Gelar Adat :</label>
                                    <input type="text" value="{{ isset($member->title_adat) ? $member->title_adat->name : '-' }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Foto Diri :</label><br>
                                    <img src="{{ url('photo/member/'.$member->photo) }}" onerror="this.src='{{ url('assets/global/img/no-profile.jpg') }}'" alt="Image" width="170px" height="150px"/>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Nama Panggilan :</label>
                                    <input type="text" value="{{ $member->sur_name }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Kota / Kabupaten :</label>
                                    <input type="text" value="{{ $member->city->name }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Status Hidup :</label>
                                    @if($member->is_life == 1)
                                        <input type="text" value="Hidup" disabled class="form-control" required/>
                                    @else
                                        <input type="text" value="Meninggal" disabled class="form-control" required/>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Jenis Kelamin :</label>
                                    <input type="text" value="{{ $member->gender_status }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Status Pernikahan :</label>
                                    <input type="text" value="{{ $member->marital->name }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Tahun Kelulusan :</label>
                                    <input type="text" value="{{ $member->graduation_year }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">No Telepon :</label>
                                    <input type="text" value="{{ $member->phone_number }}" disabled class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Status :</label>
                                    <input type="text" value="{{ $member->member_status->name }}" disabled class="form-control" required/>
                                </div>               
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

@endsection

@section('myscript')
    <script src="{{ asset('assets/global/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/add-family.js') }}"></script>
    <script>
    $(function () {
        var base_url = "http://localhost/iws/public/";

        $('#province-selected').on('change', function() {
            $('#city-selected').empty().append('<option value="">Pilih Kota</option>');
            $.ajax({
                url: base_url + "master/district/get-list-city/"+this.value,
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

        $('#city-selected').on('change', function() {
            $('#district-selected').empty().append('<option value="">Pilih Kecamatan</option>');
            $.ajax({
                url: base_url + "master/village/get-list-district/"+this.value,
                method: 'get',
                success : function(data) {
                    var parse_data = JSON.parse(data);
                    if(parse_data.length > 0) {
                        $('#district-selected').prop('disabled', false);
                        for(var index in parse_data) {
                            $("#district-selected").append('<option value="'+ parse_data[index].id +'">'+ parse_data[index].name +'</option>');
                        }
                    } else {
                        $('#district-selected').prop('disabled', true);
                    }
                },
                error : function(err){
                    $('#district-selected').prop('disabled', true);
                }
            });
        });

        $('#district-selected').on('change', function() {
            $('#village-selected').empty().append('<option value="">Pilih Kelurahan</option>');
            $.ajax({
                url: base_url + "master/village/get-list-village/"+this.value,
                method: 'get',
                success : function(data) {
                    var parse_data = JSON.parse(data);
                    if(parse_data.length > 0) {
                        $('#village-selected').prop('disabled', false);
                        for(var index in parse_data) {
                            $("#village-selected").append('<option value="'+ parse_data[index].id +'">'+ parse_data[index].name +'</option>');
                        }
                    } else {
                        $('#village-selected').prop('disabled', true);
                    }
                },
                error : function(err){
                    $('#village-selected').prop('disabled', true);
                }
            });
        });

        // $("select").select2();
        $('#sorting-table').DataTable( {
            "dom": '<"toolbar">frtip',
            "ordering": false,
            "info":     false,
            language: { search: "", searchPlaceholder: "Pencarian"  },
        } );
        $("div.toolbar").html('<a class="float-right btn btn-success" href="#">Sembunyikan Detail</a>');

        var alert = $('div.alert[auto-close]');
        alert.each(function() {
            var that = $(this);
            var time_period = that.attr('auto-close');
            setTimeout(function() {
                that.alert('close');
            }, time_period);
        });
    });
        $('[type=tel]').on('change', function(e) {
            $(e.target).val($(e.target).val().replace(/[^\d\.]/g, ''))
        });
        $('[type=tel]').on('keypress', function(e) {
            keys = ['0','1','2','3','4','5','6','7','8','9','.']
            return keys.indexOf(event.key) > -1
        });
    </script>
@endsection