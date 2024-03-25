<!DOCTYPE html>
<html>
    <head>
        <title>Data User</title>
    </head>
    <body>

    <h1>Form Tambah Data user</h1>
    <a href="{{route('/user')}}">Kembali</a>
    <form method="post" action="{{route('/user/tambah_simpan')}}">


        {{csrf_field()}}

        <label>Username</label>
        <input type="text" name="username" placeholder="Masukkan Username">
        <br>
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukkan Nama">
        <br>
        <label>Password</label>
        <input type="password" name="Password" placeholder="Masukkan Password">
        <br>
        <label>Level ID</label>
        <input type="number" name="level_id" placeholder="Masukkan ID Level">
        <br><br>
        <input type="submit" class="btn btn-success" value="Simpan">

    </form>
</body>
</html>