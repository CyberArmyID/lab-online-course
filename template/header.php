<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<!-- Bootstrap, fontaweso and CSS -->
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/css/all.min.css">
<style>
    body {
        background: #EAEAEF;
    }

    .info img {
        width: 130px;
        height: 130px;
        margin: auto;
        margin-top: 10%;
        transition: 0.8s ease;
    }

    .info img:hover {
        width: 147px;
        height: 147px;
    }

    .pagelog {
        width: 500px;
        max-width: 100%;
        border-radius: 4px;
        box-shadow: 2px 5px 10px #7a7474;
    }

    .container h4 {
        font-family: "lora";
        font-weight: bold;
    }

    .ket a {
        width: 210px;
        font-family: "lora";
        font-size: 24px;
    }

    .features p a {
        margin-right: 5px;
        margin-left: 5px;
    }

    .features p span {
        font-size: 18px;
    }

    .sale .figure-caption {
        position: absolute;
        bottom: 15px;
        left: 30px;
        right: 15px;
    }

    h5 {
        font-size: 22px;
        font-family: 'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', sans-serif;
        font-weight: 700;
        color: #171717;
    }

    .sale .har {
        font-size: 16px;
        font-family: Arial;
        color: #FA591D;
        font-weight: 600;
    }

    .sale {
        box-shadow: 2px 3px 8px #7a7474;
        height: 380px;

    }

    a.btn-outline-info {
        margin-bottom: -8px;
    }

    .subheader {
        background: white;
        color: #4e4e4e;
        text-align: center;
        padding: 5px;
        height: 50px;
        padding-top: 2px;
        width: 100%;
        border-bottom-left-radius: 45px;
        border-bottom-right-radius: 45px;
        box-shadow: 0px 6px 8px #beb6b6;

    }

    /* tambahan */
    .navbar {
        background: #171717;
        position: fixed;
        left: 0;
        top: 0;
        right: 0;
        margin: auto;
        z-index: 10;
        box-shadow: -15px 0px 30px #4e4e4e;
    }

    .nav-item {
        margin-right: 24px;
        font-weight: 400;
    }

    .nav-item.active a {
        color: #f9B234 !important;
        font-weight: 600;
    }

    .navbar-brand a {
        font-weight: 600;
    }

    .navbar-brand span {
        font-size: 24px;
    }

    .nav-link span {
        color: #f9B234;
        font-weight: 600;
    }

    .nav-link.user {
        font-size: 16px;
    }

    /* akhir navigasi */

    .logo-bawah {
        width: 240px;
    }

    /* Responsive */
    @media (max-width: 769px) {
        .sale {
            height: 470px;

        }

        .nama-user {
            font-size: 18px
        }

        .logo-bawah {
            width: 100%;
        }
    }

    /* akhir responsive */
    /* single */

    .main-page {
        border-radius: 8px;
        /* box-shadow: 0px 5px 10px #7a7474; */
    }

    /* single */
    .harga {
        font-size: 18px;
        font-family: Arial;
        color: #FA591D;
        font-weight: 600;
    }

    h4.nama-produk {
        font-family: "montserrat";
    }

    .colorinput {
        margin: 0;
        position: relative;
        cursor: pointer
    }

    .colorinput-color {
        display: inline-block;
        width: 1.75rem;
        height: 1.75rem;
        border-radius: 3px;
        border: 1px solid rgba(0, 40, 100, .12);
        color: #fff;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .05)
    }

    .PNF {
        margin-top: 80px;
        height: 300px;
        margin: auto;
    }

    .PNF h1 {
        margin-top: 10px;
        margin-bottom: -7px;
        margin-left: -20px;
        font-size: 150px;
        font-weight: 800;
        color: #201f1f;
    }

    .PNF h2 {
        font-size: 40px;
        font-weight: 600;
    }

    .PNF p {
        font-size: 18px;
    }

    .PNF a {
        font-size: 18px;
        font-weight: 600;
    }
</style>