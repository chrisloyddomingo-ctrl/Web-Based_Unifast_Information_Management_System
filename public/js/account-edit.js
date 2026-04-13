$(document).ready(function () {
    if (window.openPasswordModalOnLoad) {
        $('#changePasswordModal').modal('show');
    }

    $('.toggle-password').on('click', function () {
        const target = $($(this).data('target'));
        const icon = $(this).find('i');

        if (target.attr('type') === 'password') {
            target.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            target.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    function checkPasswordStrength(password) {
        let score = 0;

        if (password.length >= 8) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;

        return score;
    }

    $('#new_password').on('keyup', function () {
        const password = $(this).val();
        const score = checkPasswordStrength(password);
        const bar = $('#passwordStrengthBar');
        const text = $('#passwordStrengthText');

        let width = 0;
        let barClass = '';
        let label = '—';

        if (password.length === 0) {
            width = 0;
            barClass = '';
            label = '—';
        } else if (score <= 2) {
            width = 25;
            barClass = 'bg-danger';
            label = 'Weak';
        } else if (score === 3) {
            width = 50;
            barClass = 'bg-warning';
            label = 'Fair';
        } else if (score === 4) {
            width = 75;
            barClass = 'bg-info';
            label = 'Good';
        } else {
            width = 100;
            barClass = 'bg-success';
            label = 'Strong';
        }

        bar.removeClass('bg-danger bg-warning bg-info bg-success')
            .addClass(barClass)
            .css('width', width + '%');

        text.text('Password strength: ' + label);
    });

    $('#new_password, #password_confirmation').on('keyup', function () {
        const password = $('#new_password').val();
        const confirmPassword = $('#password_confirmation').val();
        const matchText = $('#passwordMatchText');

        if (confirmPassword.length === 0) {
            matchText.text('').removeClass('text-success text-danger');
        } else if (password === confirmPassword) {
            matchText.text('Passwords match.')
                .removeClass('text-danger')
                .addClass('text-success');
        } else {
            matchText.text('Passwords do not match.')
                .removeClass('text-success')
                .addClass('text-danger');
        }
    });

    if (window.successMessage) {
        $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Success',
            autohide: true,
            delay: 3500,
            body: window.successMessage
        });
    }
});