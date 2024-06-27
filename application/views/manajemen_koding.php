<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-blue-900,
        .bg-blue-700,
        .text-blue-900 {
            background-color: #7FB0C5 !important;
        }

        .bg-gray-100 {
            background-color: rgba(127, 176, 197, 0.4) !important;
        }

        .bg-card {
            background-color: rgba(168, 212, 215, 0.7) !important;
        }

        /* Custom height classes */
        .h-custom {
            height: 400px; /* You can change this value to adjust the height */
        }
    </style>
</head>

<body class="bg-gray-100">
    <nav class="bg-blue-900 border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Sistem Verifikasi Internal</span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-blue-900 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="<?= base_url('excel') ?>" class="block py-2 px-3 text-black bg-blue-900 rounded md:bg-transparent md:bg-black md:p-0" aria-current="page">Administrasi</a>
                    </li>
                    <li>
                        <a href="<?= base_url('Koding/manajemen') ?>" class="block underline py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Koding</a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/dashboard') ?>" class="block py-2 px-3 text-gray-900 rounded hover:bg-black hover:underline md:hover:bg-transparent md:border-0 md:hover:text-black md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Kembali</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="p-10 h-screen">
        <div class="mb-5 pt-18 text-center">
            <h1 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Aspek Koding</h1>
        </div>
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="text-green-500 text-sm bg-green-100 p-4 w-full mb-4 rounded">
                <?= $this->session->flashdata('message') ?>
            </div>
        <?php endif ?>
        <div class="grid grid-cols-2 gap-4">
            <a href="<?= base_url('Koding/tambahkoding') ?>" class="flex items-center justify-center max-w-full h-custom pb-6 bg-card shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <div class="flex flex-col items-center justify-center">
                    <div class="flex items-center justify-center w-24 h-24 bg-gray-200 rounded-full">
                        <i class="fa fa-file-alt fa-4x text-gray-800"></i>
                    </div>
                    <div class="pt-4">
                        <h4 class="text-2xl font-bold text-center">Tambah Kode</h4>
                    </div>
                </div>
            </a>
            <a href="<?= base_url('koding') ?>" class="flex items-center justify-center max-w-full h-custom pb-6 bg-card rounded shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <div class="flex flex-col items-center justify-center">
                    <div class="flex items-center justify-center w-24 h-24 bg-gray-200 rounded-full">
                        <i class="fa fa-code fa-4x text-gray-800"></i>
                    </div>
                    <div class="pt-4">
                        <h4 class="text-2xl font-bold text-center">Cek Koding</h4>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>

</html>