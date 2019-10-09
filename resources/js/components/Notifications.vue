<template>
    <li class="nav-item dropdown" @click="initStream()">
        <a
            href="#"
            class="nav-link dropdown-toggle"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        >
            <i class="far fa-bell"></i> {{ notifications.length }} <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right notifications">
            <h6 class="dropdown-header bg-white">Notifications</h6>

            <notification v-if="notification" :message="notification.message" :level="notification.level"></notification>

            <a href="#" class="dropdown-item" v-for="notification in notifications">
                Test
            </a>

            <div v-if="initialLoad === false && notifications.length === 0" class="dropdown-item">
                You have no notifications.
            </div>

            <div class="dropdown-divider"></div>

            <div class="p-2 px-3">
                <a class="btn btn-block btn-sm btn-primary" href="#">View All</a>
            </div>
        </div>
    </li>
</template>

<script>
    import Spinner from 'vue-simple-spinner';

    export default {
        components: {Spinner},

        props: {
            url: {
                type:String,
                required:true,
            },
            defaultNotifications: {
                type:Array,
                default:[],
            }
        },

        data() {
            return {
                notifications:this.defaultNotifications,
                initialLoad:true,
                notification:false,
            };
        },

        mounted() {
            this.initStream();
        },

        methods: {
            /**
             * Initializes the event stream.
             */
            initStream() {
                window.Notifier.onMessage((notifications) => {
                    this.notifications = notifications;

                    // Since our beginning events won't be loaded yet, we don't
                    // want to display a notification of new events being
                    // added until this actually occurs.
                    if (this.initialLoad === false && this.notifications.length > 0) {
                        if (this.notifications.length < notifications.length) {
                            this.showNotification('New notification!', 'info');
                        }
                    }

                    this.initialLoad = false;
                });
            },

            /**
             * Displays a flash notification.
             *
             * @param {String} message
             * @param {String} level
             */
            showNotification(message, level) {
                this.notification = {
                    message: message,
                    level: level,
                };

                // Clear the notification after 2 seconds.
                setTimeout(() => this.notification = false, 2000);
            },
        },
    }
</script>
