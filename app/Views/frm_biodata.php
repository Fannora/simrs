<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Biodata Mahasiswa</h2>
    
    <?= validation_list_errors()?>

    <?= form_open('/formbiodata')?>
        <label for="fname">Nim:</label><br>
        <input type="text" name="fnim" placeholder="Masukan Nim" maxlength="12" ><br>
        <label for="lname">Nama:</label><br>
        <input type="text" name="fnama" placeholder="Masukan Nama" ><br>
        <label for="lname">Alamat:</label><br>
        <input type="text" name="falamat" placeholder="Masukan Alamat" ><br><br>
        <input type="submit" value="Submit">
    <?= form_close()?>
</body>
</html>