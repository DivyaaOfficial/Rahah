<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-biasa.php');

// Ambil senarai calon
$calon = mysqli_query($condb, "SELECT * FROM CALON");
$senarai = [];
while ($row = mysqli_fetch_assoc($calon)) {
    $senarai[] = $row;
}

// Ambil senarai jawatan dari pangkalan data
$jawatan_query = mysqli_query($condb, "SELECT * FROM jawatan");
$jawatan = [];
while ($row = mysqli_fetch_assoc($jawatan_query)) {
    $jawatan[] = $row['nama_jawatan'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Borang Undian Kelab Sains Komputer</title>
    <script>
        function enforceSingleJawatanPerCalon() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            const selectedJawatan = {};

            checkboxes.forEach(checkbox => {
                const calonId = checkbox.name.match(/\[(.*?)\]/)[1];

                if (!selectedJawatan[calonId]) {
                    selectedJawatan[calonId] = {
                        selected: null,
                        checkboxes: []
                    };
                }
                selectedJawatan[calonId].checkboxes.push(checkbox);

                if (checkbox.checked) {
                  selectedJawatan[calonId].selected = checkbox.value;
                }
              });

Object.values(selectedJawatan).forEach(calon => {
    calon.checkboxes.forEach(checkbox => {
        if (calon.selected && checkbox.value !== calon.selected) {
            checkbox.disabled = true;
        } else {
            checkbox.disabled = false;
        }
    });
});

disableDuplicateSelection();
}

function disableDuplicateSelection() {
    const selectedValues = {};
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            if (selectedValues[checkbox.value]) {
                checkbox.checked = false;
            } else {
                selectedValues[checkbox.value] = true;
            }
        }
    });

    checkboxes.forEach(checkbox => {
        if (selectedValues[checkbox.value] && !checkbox.checked) {
            checkbox.disabled = true;
        }
    });
}

function handleCheckboxClick(checkbox) {
    const calonId = checkbox.name.match(/\[(.*?)\]/)[1];
    const calonCheckboxes = document.querySelectorAll('input[name="undi[' + calonId + ']"]');
    calonCheckboxes.forEach(cb => {
    if (cb !== checkbox) {
        cb.checked = false;
    }
});

enforceSingleJawatanPerCalon();
}
</script>
</head>
<body>

<h2>BORANG UNDIAN JAWATANKUASA KELAB SAINS KOMPUTER</h2>

<form action="proses_undi_kedudukan.php" method="POST"
      onchange="enforceSingleJawatanPerCalon()">

<input type="hidden" name="nokp" value="<?= $_SESSION['nokp'] ?>">

<?php
foreach ($senarai as $cl) {
    echo '<div>';
    echo '<img src="' . $cl['gambar'] . '" alt="' . $cl['nama_calon'] . '" width="150">';
    echo '<p>' . $cl['nama_calon'] . '</p>';

    foreach ($jawatan as $j) {
        echo '<label>';
        echo '<input type="checkbox" name="undi[' . $cl['id_calon'] . ']" value="' . $j . '" onclick="handleCheckboxClick(this)"> ' . $j;
        echo '</label><br>';
    }

    echo '<hr></div>';
}
?>

<input type="submit" value="SUBMIT">
</form>

</body>
</html>
