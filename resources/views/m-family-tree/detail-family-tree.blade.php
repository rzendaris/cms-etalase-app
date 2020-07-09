@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
.table {
    width:100%;
}
.img-custom-1 {
    width:100%;
}
.img-custom-2 {
    width:60%;
    margin:auto;
    display: block;
}
.img-custom-3 {
    width:100%;
}
.box-detail-tre {
    padding: 1em;
    border: solid 1px #f2f6f9;
}
.custom-button-lihat {
    width: 100%;
    margin: 10px 0;
}
.custom-button-pdf {
    position: absolute;
}
</style>
@endsection

@section('content')

<!-- Button Download PDF -->
<button style=" margin: 10px; " class="btn btn-success custom-button-pdf p-2" onclick="download()">Download PDF</button>
<div class="content-body-white" id="divContent">    
    <div class="row">
        <div class="col-md-offset-4 col-md-4">  
            <h1 class="text-center">IWS Family Tree</h1>
            <div class="box-detail-tre">
                @if($data['family']->photo == NULL)
                    <img class="img-custom-2" src="{{ asset('assets/global/img/no-profile.jpg') }}" />
                @else
                    <img class="img-custom-1" src="{{ url('photo/kk/'.$data['family']->photo) }}" onerror="this.src='{{ url('assets/global/img/no-profile.jpg') }}'" /> 
                @endif
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        @foreach($data['family_member'] as $member)
            @if(isset($member->member_belongs))
                @if($member->member_belongs->member_status_id == 1)
                <div class="col-md-6">  
                    <div class="box-detail-tre">
                        @if($member->member_belongs->photo == NULL)
                            <img class="img-custom-2" src="{{ asset('assets/global/img/no-profile.jpg') }}" />
                        @else
                            <img class="img-custom-2" src="{{ url('photo/member/'.$member->member_belongs->photo) }}" onerror="this.src='{{ url('assets/global/img/no-profile.jpg') }}'"/>
                        @endif
                        <hr>
                        <table class="table table-striped"> 
                            <tbody>
                                <tr>
                                    <th scope="row">Nama Lengkap</th>
                                    <td>{{ $member->member_belongs->full_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nama Panggilan</th>
                                    <td>{{ $member->member_belongs->sur_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tanggal Lahir</th>
                                    <td>{{ $member->member_belongs->birthday }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Jenis Kelamin</th>
                                    <td>{{ $member->member_belongs->gender_status }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Pernikahan</th>
                                    <td>{{ $member->member_belongs->marital->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Kewarganegaraan</th>
                                    <td>{{ $member->member_belongs->nationality_status }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Status</th>
                                    <td>{{ $member->member_belongs->member_status->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Gelar</th>
                                    <td>{{ isset($member->member_belongs->title_adat) ? $member->member_belongs->title_adat->name : '-' }} </td>
                                </tr>
                                <tr>
                                    <th scope="row">Suku</th>
                                    <td>{{ isset($member->member_belongs->ethnic) ? $member->member_belongs->ethnic->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Pendidikan</th>
                                    <td>{{ isset($member->member_belongs->education) ? $member->member_belongs->education->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nama Sekolah</th>
                                    <td>{{ $member->member_belongs->school_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tahun Lulus</th>
                                    <td>{{ $member->member_belongs->graduation_year }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Jenis Pekerjaan</th>
                                    <td>{{ isset($member->member_belongs->job) ? $member->member_belongs->job->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nama Institusi / Usaha</th>
                                    <td>{{ $member->member_belongs->instance_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Keberadaan</th>
                                    @if($member->member_belongs->is_life == 1)
                                        <td>Hidup</td>
                                    @else
                                        <td>Meninggal</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th scope="row">Domisili</th>
                                    <td>{{ $member->member_belongs->city->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Kecamatan</th>
                                    <td>{{ $member->member_belongs->district->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Kelurahan</th>
                                    <td>{{ $member->member_belongs->village->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">No Telp</th>
                                    <td>{{ $member->member_belongs->phone_number }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Alamat</th>
                                    <td>{{ $member->member_belongs->address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                @if($member->member_belongs->member_status_id == 2)
                <div class="col-md-6">  
                    <div class="box-detail-tre">
                        @if($member->member_belongs->photo == NULL)
                            <img class="img-custom-2" src="{{ asset('assets/global/img/no-profile.jpg') }}" />
                        @else
                            <img class="img-custom-2" src="{{ url('photo/member/'.$member->member_belongs->photo) }}" onerror="this.src='{{ url('assets/global/img/no-profile.jpg') }}'" />
                        @endif
                        <hr>
                        <table class="table table-striped"> 
                            <tbody>
                                <tr>
                                    <th scope="row">Nama Lengkap</th>
                                    <td>{{ $member->member_belongs->full_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nama Panggilan</th>
                                    <td>{{ $member->member_belongs->sur_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tanggal Lahir</th>
                                    <td>{{ $member->member_belongs->birthday }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Jenis Kelamin</th>
                                    <td>{{ $member->member_belongs->gender_status }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Pernikahan</th>
                                    <td>{{ $member->member_belongs->marital->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Kewarganegaraan</th>
                                    <td>{{ $member->member_belongs->nationality_status }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Status</th>
                                    <td>{{ $member->member_belongs->member_status->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Gelar</th>
                                    <td>{{ isset($member->member_belongs->title_adat) ? $member->member_belongs->title_adat->name : '-' }} </td>
                                </tr>
                                <tr>
                                    <th scope="row">Suku</th>
                                    <td>{{ isset($member->member_belongs->ethnic) ? $member->member_belongs->ethnic->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Pendidikan</th>
                                    <td>{{ isset($member->member_belongs->education) ? $member->member_belongs->education->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nama Sekolah</th>
                                    <td>{{ $member->member_belongs->school_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tahun Lulus</th>
                                    <td>{{ $member->member_belongs->graduation_year }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Jenis Pekerjaan</th>
                                    <td>{{ isset($member->member_belongs->job) ? $member->member_belongs->job->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nama Institusi / Usaha</th>
                                    <td>{{ $member->member_belongs->instance_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Keberadaan</th>
                                    @if($member->member_belongs->is_life == 1)
                                        <td>Hidup</td>
                                    @else
                                        <td>Meninggal</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th scope="row">Domisili</th>
                                    <td>{{ $member->member_belongs->city->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Kecamatan</th>
                                    <td>{{ $member->member_belongs->district->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Kelurahan</th>
                                    <td>{{ $member->member_belongs->village->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">No Telp</th>
                                    <td>{{ $member->member_belongs->phone_number }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Alamat</th>
                                    <td>{{ $member->member_belongs->address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            @endif
        @endforeach
    </div>
    <br>

    <div class="row">
        <div class="col-md-offset-4 col-md-4">  
            <h1 class="text-center">Garis Keturunan</h1>
        </div>
    </div>
    <br>
    <div class="row">        
        <div class="col-md-12">  
            <div class="box-detail-tre">
                <div class="row">
                    @if(isset($data['family']->parents))
                        <div class="col-md-6">
                            @foreach($data['family']->parents as $parents)
                                <div class="row">
                                    <div class="col-md-4">
                                        @if($parents->photo == NULL)
                                            <img class="img-custom-2" src="{{ asset('assets/global/img/no-profile.jpg') }}" />
                                        @else
                                            <img class="img-custom-2" src="{{ url('photo/member/'.$parents->photo) }}" onerror="this.src='{{ url('assets/global/img/no-profile.jpg') }}'" />
                                        @endif
                                        <a href="{{ url('family-tree-detail/'.$parents->id) }}" class="btn btn-primary custom-button-lihat">Lihat</a>
                                    </div>
                                    <div class="col-md-8">
                                        <table class="table table-striped"> 
                                            <tbody>
                                                <tr>
                                                    <th scope="row" style="width:125px">Nama Lengkap</th>
                                                    <td>{{ $parents->full_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Status</th>
                                                    <td>Orang Tua / {{ $parents->member_status->name }}</td>
                                                </tr> 
                                                <tr>
                                                    <th scope="row">Suku</th>
                                                    <td>{{ isset($parents->ethnic) ? $parents->ethnic->name : '-' }}</td>
                                                </tr> 
                                                <tr>
                                                    <th scope="row">Jenis Kelamin</th>
                                                    <td>{{ $parents->gender_status }}</td>
                                                </tr> 
                                                <tr>
                                                    <th scope="row">Gelar</th>
                                                    <td>{{ isset($parents->title_adat) ? $parents->title_adat->name : '-' }}</td>
                                                </tr>                       
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="col-md-6">
                    @foreach($data['family_member'] as $member)
                        @if(isset($member->member_belongs))
                            @if($member->member_belongs->member_status_id != 1 && $member->member_belongs->member_status_id != 2)
                                <div class="row">
                                    <div class="col-md-4">
                                        @if($member->member_belongs->photo == NULL)
                                            <img class="img-custom-2" src="{{ asset('assets/global/img/no-profile.jpg') }}" />
                                        @else
                                            <img class="img-custom-2" src="{{ url('photo/member/'.$member->member_belongs->photo) }}" onerror="this.src='{{ url('assets/global/img/no-profile.jpg') }}'" />
                                        @endif
                                        <!-- <a href="#" class="btn btn-primary custom-button-lihat">Lihat</a> -->
                                    </div>
                                    <div class="col-md-8">
                                        <table class="table table-striped"> 
                                            <tbody>
                                                <tr>
                                                    <th scope="row" style="width:125px">Nama Lengkap</th>
                                                    <td>{{ $member->member_belongs->full_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Status</th>
                                                    <td>{{ $member->member_belongs->member_status->name }}</td>
                                                </tr> 
                                                <tr>
                                                    <th scope="row">Suku</th>
                                                    <td>{{ isset($member->member_belongs->ethnic) ? $member->member_belongs->ethnic->name : '-' }}</td>
                                                </tr> 
                                                <tr>
                                                    <th scope="row">Jenis Kelamin</th>
                                                    <td>{{ $member->member_belongs->gender_status }}</td>
                                                </tr> 
                                                <tr>
                                                    <th scope="row">Gelar</th>
                                                    <td>{{ isset($member->member_belongs->title_adat) ? $member->member_belongs->title_adat->name : '-' }}</td>
                                                </tr>                       
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                    @if(isset($data['family']->inherit_family))
                        @foreach($data['family']->inherit_family as $inherit_family)
                            <div class="row">
                                <div class="col-md-4">
                                    @if($inherit_family->photo == NULL)
                                        <img class="img-custom-2" src="{{ asset('assets/global/img/no-profile.jpg') }}" />
                                    @else
                                        <img class="img-custom-2" src="{{ url('photo/member/'.$inherit_family->photo) }}" onerror="this.src='{{ url('assets/global/img/no-profile.jpg') }}'" />
                                    @endif
                                    <a href="{{ url('family-tree-detail/'.$inherit_family->id) }}" class="btn btn-primary custom-button-lihat">Lihat</a>
                                </div>
                                <div class="col-md-8">
                                    <table class="table table-striped"> 
                                        <tbody>
                                            <tr>
                                                <th scope="row" style="width:125px">Nama Lengkap</th>
                                                <td>{{ $inherit_family->full_name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Status</th>
                                                <td>Anak / {{ $inherit_family->member_status->name }}</td>
                                            </tr> 
                                            <tr>
                                                <th scope="row">Suku</th>
                                                <td>{{ isset($inherit_family->ethnic) ? $inherit_family->ethnic->name : '-' }}</td>
                                            </tr> 
                                            <tr>
                                                <th scope="row">Jenis Kelamin</th>
                                                <td>{{ $inherit_family->gender_status }}</td>
                                            </tr> 
                                            <tr>
                                                <th scope="row">Gelar</th>
                                                <td>{{ isset($inherit_family->title_adat) ? $inherit_family->title_adat->name : '-' }}</td>
                                            </tr>                       
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('myscript')
    <script src="{{ asset('assets/global/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/html2pdf.bundle.js') }}"></script>
    <script>
      function download() {
        // Hide All Button Detail
        $(".custom-button-lihat").css('display','none');
        // Get the element.
        var element = document.getElementById('divContent');
        html2pdf().from(element).set({
          margin: 0.2,
          image: { type: 'jpeg', quality: 1},
          filename: 'Family-Tree.pdf',
          html2canvas: { scale: 2 },
          jsPDF: {orientation: 'portrait', unit: 'in', format: 'letter', compressPDF: true}
        }).toPdf().get('pdf').then(function (pdf) {
            pdf.autoPrint();
            window.open(pdf.output('bloburl'), '_blank');
            // Show All Button Detail
            setTimeout(function() {
                $(".custom-button-lihat").css('display','block');
            }, 5000);
        });
      }
    </script>
@endsection