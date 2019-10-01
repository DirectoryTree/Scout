<template>
    <div>
        <slot :select="select" :isSelected="isSelected"></slot>
    </div>
</template>

<script>
    export default {
        props: {
            initialSelection: {
                type:String,
                required:false,
            }
        },

        /**
         * The component data.
         *
         * @return {Object}
         */
        data() {
            return {
                selected: 'dn',
                hidden: null,
            };
        },

        /**
         * Set the initial input selection upon load.
         */
        mounted() {
            this.select(this.initialSelection);
        },

        methods: {
            /**
             * Selects an input.
             *
             * @param {String} value
             */
            select(value) {
                this.selected = value;
            },

            /**
             * Determine if an input is selected.
             *
             * @param {String} value
             *
             * @returns {boolean}
             */
            isSelected(value) {
                return this.selected === value;
            },
        }
    }
</script>
