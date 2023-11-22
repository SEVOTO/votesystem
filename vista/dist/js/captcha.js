document.addEventListener('DOMContentLoaded', function () {
    showCaptchaAlert();
});
document.addEventListener('DOMContentLoaded', function () {
    disableCopyPaste();
});

function disableCopyPaste() {
    var body = document.getElementsByTagName('body')[0];
    body.oncopy = function (event) {
        event.preventDefault();
    };
    body.onpaste = function (event) {
        event.preventDefault();
    };
}
let captchaGenerated;

function generateCaptcha() {
    let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let captcha = '';
    for (let i = 0; i < 6; i++) {
        captcha += chars[Math.floor(Math.random() * chars.length)];
    }
    captchaGenerated = captcha;
    return captcha;
}

function showCaptchaAlert() {
    generateCaptcha();
    Swal.fire({
        title: '<h1>Por favor, ingrese el captcha:</h1>',
        html: '<h3>Captcha generado:</h3> <strong style="font-size: 5em;background-color: #1a1a1a; padding: 1px; border-radius: 10px; color: white;">' + captchaGenerated + '</strong>',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off',
            autocorrect: 'off',
            autofocus: 'on',
            required: 'required',
        },
        confirmButtonText: '<h4>Verificar</h4>',
        allowOutsideClick: () => false, // Previene que el usuario salga del cuadro pulsando fuera
        showLoaderOnConfirm: true,
        preConfirm: (inputCaptcha) => {
            if (inputCaptcha.toLowerCase() === captchaGenerated.toLowerCase()) {
                Swal.fire({
                    title: 'Correcto!',
                    icon: 'success',
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'El captcha ingresado es incorrecto.',
                    icon: 'error',
                });
                window.location.href = 'logout.php';
            }
        },
    });
}