<!DOCTYPE html>
<html lang="en">

<head>
    <!-- External CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

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
            height: 400px;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .modal-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 40%;
            /* Increased width */
        }

        .modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 1.5rem;
        }

        .modal-toggle:checked+.modal {
            display: block;
        }

        /* Styling DataTable elements */
        .dataTables_wrapper .dataTables_length select {
            width: auto;
            display: inline-block;
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            padding: 0.25rem;
        }

        .dataTables_wrapper .dataTables_filter {
            text-align: left;
        }

        .dataTables_wrapper .dataTables_paginate {
            text-align: center;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Flash Message -->
    <?php if ($this->session->flashdata('message')) : ?>
        <div class="bg-<?= $this->session->flashdata('message_type') ?>-500 text-white px-4 py-2">
            <?= $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>

    <!-- Navigation Bar -->
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
                        <a href="<?= base_url('excel') ?>" class="block py-2 px-3 text-black bg-blue-900 rounded md:bg-transparent md:p-0" aria-current="page">Administrasi</a>
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

    <!-- Main Content -->
    <div class="container mx-auto p-10">
        <!-- Card Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <!-- Add Button -->
            <label for="addModal" class="mb-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">Tambah</label>

            <!-- Data Table -->
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table table-striped mx-auto my-8" id="dataTable">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center">No</th>
                            <th scope="col" class="px-6 py-3 text-center">Kode 1</th>
                            <th scope="col" class="px-6 py-3 text-center">Kode 2</th>
                            <th scope="col" class="px-6 py-3 text-center">Keterangan</th>
                            <th scope="col" class="px-6 py-3 text-center">Kode BPJS</th>
                            <th scope="col" class="px-6 py-3 text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <?php $no = 1;
                        foreach ($koding as $row) { ?>
                            <tr class="<?= $no % 2 == 0 ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' ?>">
                                <td class="px-6 py-4 text-center"><?= $no++ ?></td>
                                <td class="px-6 py-4 text-center"><?= $row->kode_satu ?></td>
                                <td class="px-6 py-4 text-center"><?= $row->kode_dua ?></td>
                                <td class="px-6 py-4 text-left"><?= $row->keterangan ?></td>
                                <td class="px-6 py-4 text-center"><?= $row->kode_bpjs ?></td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-start space-x-2">
                                        <!-- Edit Button and Modal -->
                                        <label for="editModal<?= $row->id ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">Edit</label>
                                        <input type="checkbox" id="editModal<?= $row->id ?>" class="modal-toggle hidden" />
                                        <div class="modal">
                                            <div class="modal-box bg-white w-1/3 m-auto p-6 rounded-lg shadow-lg">
                                                <label for="editModal<?= $row->id ?>" class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-sm text-white z-50">
                                                    <svg class="fill-current text-red-500" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                                        <path d="M1 17L17 1M1 1l16 16" />
                                                    </svg>
                                                    <span>(Esc)</span>
                                                </label>
                                                <h3 class="font-bold text-lg mb-4">Edit Data</h3>
                                                <form action="<?= base_url('Koding/update_koding/' . $row->id) ?>" method="post">
                                                    <div class="form-control mb-4">
                                                        <label for="kode_satu" class="label">Kode 1</label>
                                                        <input type="text" name="kode_satu" class="input input-bordered w-full" value="<?= $row->kode_satu ?>" />
                                                    </div>
                                                    <div class="form-control mb-4">
                                                        <label for="kode_dua" class="label">Kode 2</label>
                                                        <input type="text" name="kode_dua" class="input input-bordered w-full" value="<?= $row->kode_dua ?>" />
                                                    </div>
                                                    <div class="form-control mb-4">
                                                        <label for="keterangan" class="label">Keterangan</label>
                                                        <textarea name="keterangan" class="textarea textarea-bordered w-full"><?= $row->keterangan ?></textarea>
                                                    </div>
                                                    <div class="form-control mb-4">
                                                        <label for="kode_bpjs" class="label">Kode BPJS</label>
                                                        <input type="text" name="kode_bpjs" class="input input-bordered w-full" value="<?= $row->kode_bpjs ?>" />
                                                    </div>
                                                    <div class="form-control mt-6 text-left">
                                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Delete Button and Confirmation -->
                                        <form action="<?= base_url('Koding/delete_koding/' . $row->id) ?>" method="post">
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Data -->
    <input type="checkbox" id="addModal" class="modal-toggle hidden" />
    <div class="modal">
        <div class="modal-box bg-white w-1/2 m-auto p-6 rounded-lg shadow-lg">
            <label for="addModal" class="modal-close absolute top-0 right-0 mt-4 mr-4 cursor-pointer flex flex-col items-center text-white text-sm z-50">
                <svg class="fill-current text-red-500" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M1 17L17 1M1 1l16 16" />
                </svg>
                <span>(Esc)</span>
            </label>
            <h3 class="font-bold text-lg mb-4">Tambah Data</h3>
            <form action="<?= base_url('Koding/tambahkoding') ?>" method="post">
                <div class="form-control mb-4">
                    <label for="kode_satu" class="label">Kode 1</label>
                    <input type="text" name="kode_satu" class="input input-bordered w-full" required />
                </div>
                <div class="form-control mb-4">
                    <label for="kode_dua" class="label">Kode 2</label>
                    <input type="text" name="kode_dua" class="input input-bordered w-full" required />
                </div>
                <div class="form-control mb-4">
                    <label for="keterangan" class="label">Keterangan</label>
                    <textarea name="keterangan" class="textarea textarea-bordered w-full" required></textarea>
                </div>
                <div class="form-control mb-4">
                    <label for="kode_bpjs" class="label">Kode BPJS</label>
                    <input type="text" name="kode_bpjs" class="input input-bordered w-full" required />
                </div>
                <div class="form-control mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- External JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

    <!-- DataTable Initialization with custom DOM -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                dom: '<"flex justify-between items-center mb-4"<"flex items-center"l><"flex items-center"f>>t<"flex justify-between items-center mt-4"<"info"i><"pagination"p>>',
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "stripeClasses": ['bg-white', 'bg-gray-50']
            });
        });
    </script>
</body>

</html>