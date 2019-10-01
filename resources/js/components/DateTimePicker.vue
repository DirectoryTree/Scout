<template>
    <flat-picker
            v-model="date"
            :config="config"
            class="form-control"
            :class="controlSize"
            placeholder="Select date"
            :name="name">
    </flat-picker>
</template>

<script>
    import FlatPicker from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    export default {
        components: {FlatPicker},

        props: {
            name: {
                type:String,
                required:true,
                default:'date',
            },
            size: {
                type:String,
                required:false,
                default:'default',
            },
            value: {
                type: [String, Date]
            }
        },

        computed: {
            controlSize() {
                switch(this.size) {
                    case 'sm':
                        return 'form-control-sm';
                    default:
                        return 'form-control';
                }
            },
        },

        data() {
            return {
                date: this.value ? this.value : null,
                config: {
                    enableTime: true,
                    altFormat: 'F j, Y H:i',
                    altInput: true,
                    dateFormat: 'Y-m-d H:i',
                },
            }
        },
    }
</script>
