<template lang="pug">
div
    h5.text-muted.text-center.mb-3 Contraseña 
    .row
        .col-md-6.mb-2
            label.small.label.text-muted Contraseña:
            input.form-control(type="password" name="password" id="password" autocomplete="off" required)
            .invalid-feedback#valid-password
        .col-md-6.mb-2
            label.small.label.text-muted Confirma la contraseña:
            input.form-control(type="password" name="confirm-password" id="confirm-password" autocomplete="off" required)
            .invalid-feedback#valid-confirm-password
        .col-12
            hr
            .text-center.py-4
                button.btn.btn-info Guardar
</template>

<script>
export default {
    name: 'form-password'
}
</script>