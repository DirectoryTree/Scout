<template>
    <form @submit.prevent="confirm">
        <slot></slot>
    </form>
</template>

<script>
    import * as Ladda from 'ladda';
    import Swal from 'sweetalert2';

    export default {
        props: {
            title: String,
            message: String,
        },

        methods: {
            confirm() {
                Swal.fire({
                    reverseButtons:true,
                    showCancelButton: true,
                    showConfirmButton: true,
                    type: 'warning',
                    title: this.title,
                    text: this.message,
                    animation:false,
                }).then((result) => {
                    if (result.value) {
                        // Submit the form upon confirmation.
                        this.$el.submit();
                    } else {
                        Ladda.stopAll();
                    }
                }).catch(() => {
                    Ladda.stopAll();
                });
            },
        }
    }
</script>
