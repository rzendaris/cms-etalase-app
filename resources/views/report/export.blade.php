<table border="1">
    <thead>
    <tr>
        <th width="10" style="background-color: #3adcfc;">User ID</th>
        <th width="20" style="background-color: #3adcfc;">Name</th>
        <th width="30" style="background-color: #3adcfc;">Email</th>
        <th width="30" style="background-color: #3adcfc;">Tanggal Lahir</th>
        <th width="50" style="background-color: #3adcfc;">Alamat</th>
        <th width="50" style="background-color: #3adcfc;">Device ID</th>
        <th width="50" style="background-color: #3adcfc;">IMEI 1</th>
        <th width="50" style="background-color: #3adcfc;">IMEI 2</th>
        <th width="50" style="background-color: #3adcfc;">Merk Device</th>
        <th width="50" style="background-color: #3adcfc;">Model Device</th>
    </tr>
    </thead>
    <tbody>
    @foreach($datas as $user)
        <tr>
            <td>{{ $user->endusers->id }}</td>
            <td>{{ $user->endusers->name }}</td>
            <td>{{ $user->endusers->email }}</td>
            <td>{{ $user->endusers->eu_birthday }}</td>
            <td>{{ $user->endusers->dev_address }}</td>
            <td>{{ $user->endusers->eu_device_id }}</td>
            <td>{{ $user->endusers->eu_imei1 }}</td>
            <td>{{ $user->endusers->eu_emei2 }}</td>
            <td>{{ $user->endusers->eu_device_brand }}</td>
            <td>{{ $user->endusers->eu_device_model }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
