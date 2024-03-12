document.addEventListener('DOMContentLoaded', function () {

    var homeElement = document.getElementById('elemento-home');

    if (homeElement) {
        document.addEventListener('keydown', function (event) {
            if (event.key === 'v' || event.key === 'V') {
                document.getElementById('link-venda').click();
            }

            if (event.key === 'c' || event.key === 'C') {
                document.getElementById('link-compra').click();
            }
        });
    }
});
