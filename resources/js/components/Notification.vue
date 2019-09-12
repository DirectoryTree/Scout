<template></template>

<script>
    import Swal from 'sweetalert2';

    export default {
        props: {
            message: String,
            level: String,
        },

        mounted() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                type: this.level,
                title: this.title,
                text: this.message,
            });
        },

        computed: {
            title() {
                switch (this.level) {
                    case 'success':
                        return 'Success';
                    case 'info':
                        return 'Information';
                    case 'error':
                        return 'Error';
                    case 'warning':
                        return 'Warning';
                }
            }
        }
    }
</script>
