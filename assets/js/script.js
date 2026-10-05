
document.addEventListener('DOMContentLoaded', function () {

    var btnToggle = document.getElementById('btnToggleSidebar');
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');

    if (btnToggle && sidebar && overlay) {
        btnToggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }

    var tombolHapus = document.querySelectorAll('.btn-hapus');

    tombolHapus.forEach(function (tombol) {
        tombol.addEventListener('click', function (e) {
            var konfirmasi = confirm('Apakah Anda yakin ingin menghapus data booking ini? Data yang sudah dihapus tidak dapat dikembalikan.');
            if (!konfirmasi) {
                e.preventDefault();
            }
        });
    });

    var alertBox = document.querySelector('.alert');
    if (alertBox) {
        setTimeout(function () {
            var bsAlert = bootstrap.Alert.getOrCreateInstance(alertBox);
            bsAlert.close();
        }, 4000);
    }

    var formBooking = document.getElementById('formBooking');
    if (formBooking) {
        formBooking.addEventListener('submit', function (e) {
            var jamMulai = formBooking.querySelector('[name="jam_mulai"]').value;
            var jamSelesai = formBooking.querySelector('[name="jam_selesai"]').value;

            if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                e.preventDefault();
                alert('Jam selesai harus lebih besar dari jam mulai!');
            }
        });
    }

    function hitungTotalBayar() {
        var jamMulaiEl   = document.getElementById('jam_mulai');
        var jamSelesaiEl = document.getElementById('jam_selesai');
        var hargaEl      = document.getElementById('harga_per_jam');
        var totalEl      = document.getElementById('total_bayar');

        if (!jamMulaiEl || !jamSelesaiEl || !hargaEl || !totalEl) {
            return;
        }

        function prosesHitung() {
            var mulai   = jamMulaiEl.value;
            var selesai = jamSelesaiEl.value;
            var harga   = parseFloat(hargaEl.value) || 0;

            if (mulai && selesai && harga > 0) {
                var pecahMulai   = mulai.split(':');
                var pecahSelesai = selesai.split(':');

                var menitMulai   = (parseInt(pecahMulai[0]) * 60) + parseInt(pecahMulai[1]);
                var menitSelesai = (parseInt(pecahSelesai[0]) * 60) + parseInt(pecahSelesai[1]);

                var selisihJam = (menitSelesai - menitMulai) / 60;

                if (selisihJam > 0) {
                    var total = selisihJam * harga;
                    totalEl.value = total.toFixed(0);
                } else {
                    totalEl.value = 0;
                }
            } else {
                totalEl.value = 0;
            }
        }

        jamMulaiEl.addEventListener('change', prosesHitung);
        jamSelesaiEl.addEventListener('change', prosesHitung);
        hargaEl.addEventListener('input', prosesHitung);

        prosesHitung();
    }

    hitungTotalBayar();

});
