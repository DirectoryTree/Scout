<template>
    <flat-picker
            v-model="date"
            :config="config"
            class="form-control"
            :class="controlSize"
            placeholder="Select date"
            :name="name"
            @input="$emit('input', date)"
    >
    </flat-picker>
</template>

<script>
    import 'flatpickr/dist/flatpickr.css';
    import FlatPicker from 'vue-flatpickr-component';

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
                    altFormat: 'M j, Y',
                    altInput: true,
                    dateFormat: 'Y-m-d',
                },
            }
        },
    }
</script>
