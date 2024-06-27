<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-center mb-6">Register</h2>
            <?php if ($this->session->flashdata('message_register_error')): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    <?php echo $this->session->flashdata('message_register_error'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('message_register_success')): ?>
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    <?php echo $this->session->flashdata('message_register_success'); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo site_url('auth/register'); ?>" method="post">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" name="username" id="username" class="w-full p-2 border border-gray-300 rounded mt-1" value="<?php echo set_value('username'); ?>">
                    <?php echo form_error('username', '<div class="text-red-600 text-sm mt-1">', '</div>'); ?>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="w-full p-2 border border-gray-300 rounded mt-1" value="<?php echo set_value('email'); ?>">
                    <?php echo form_error('email', '<div class="text-red-600 text-sm mt-1">', '</div>'); ?>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded mt-1">
                    <?php echo form_error('password', '<div class="text-red-600 text-sm mt-1">', '</div>'); ?>
                </div>
                <div class="mb-4">
                    <label for="password_confirm" class="block text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="w-full p-2 border border-gray-300 rounded mt-1">
                    <?php echo form_error('password_confirm', '<div class="text-red-600 text-sm mt-1">', '</div>'); ?>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Register</button>
            </form>
            <p class="text-center mt-4">Sudah punya akun? <a href="<?php echo site_url('auth/login'); ?>" class="text-blue-500 hover:underline">Login disini</a></p>
        </div>
    </div>
</body>
</html>