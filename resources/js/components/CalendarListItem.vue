<template>
    <b-list-group-item>
        <b-row>
            <b-col lg="2" md="3" sm="12">
                {{ day.dayWeek }}
            </b-col>
            <b-col lg="10" md="9" sm="12">
                <b-badge class="badge " v-for="(event, index) in day.events" :variant="badgeVariant(event.event_id)"
                         :key="day.id">
                    <div class="d-flex align-items-center text-capitalize">
                        {{ event.event_name }}
                        <b-button-close @click="deleteEventConfirmation(event)"
                                        class="ml-2 float-right"></b-button-close>
                    </div>
                </b-badge>
            </b-col>
        </b-row>
    </b-list-group-item>
</template>

<script>
export default {
    name: "CalendarListItem",
    props: {
        day: {
            type: Object,
            required: true
        }
    },
    methods: {
        badgeVariant(index) {
            return [
                'primary',
                'secondary',
                'success',
                'danger',
                'warning',
                'info',
                'light',
                'dark',
            ][index % 8];
        },
        async deleteEventConfirmation(event) {

            let {isDismissed: isCancelled, isDenied: isAllInstance, isConfirmed: isSingle} = await this.$swal.fire({
                title: `Do you want to delete this event? (${event.event_name})`,
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Delete`,
                denyButtonText: `Delete all instance`,
            });

            if (isCancelled) return;

            await (isAllInstance ? this.deleteEvent(event) : this.deleteEventDate(event))

        },
        async deleteEvent(event) {

            try {
                let result = await this.$swal.fire({
                    title: 'Are you sure you want to delete ALL the instance of this event?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.delete(`/api/calendar/events/${event.event_id}`)
                    },
                    allowOutsideClick: () => !this.$swal.isLoading()
                });

                this.$emit("eventdeleted", result.value.data.data)

            } catch (e) {
                this.$swal.showValidationMessage("Something went wrong.")
            }

        },
        async deleteEventDate(event) {

            try {
                let result = await this.$swal.fire({
                    title: 'Are you sure you want to delete this event?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return axios.delete(`/api/calendar/event/dates/${event.id}`)
                    },
                    allowOutsideClick: () => !this.$swal.isLoading()
                });

                this.$emit("eventdatedeleted", result.value.data.data)

            } catch (e) {
                this.$swal.showValidationMessage("Something went wrong.")
            }


        },
    }
}
</script>

<style scoped>
.badge {
    margin: 10px;
    font-size: 1em;
}
</style>
