<template>
    <b-container fluid="true" id="main-container">
        <b-row>
            <b-col cols="12">
                <b-card
                    header="Calendar"
                    header-tag="header"
                >
                    <b-row>
                        <b-col cols="3">
                            <calendar-event-add-form @eventadded="eventAdded"/>
                        </b-col>
                        <b-col cols="9">
                            <calendar-list
                                :selected-date="selectedDate"
                                :disable-calendar="isFetching"
                                :events="events"
                                @dateselected="dateSelected"
                                @eventdatedeleted="eventDateDeleted"
                                @eventdeleted="eventDeleted"
                            />
                        </b-col>
                    </b-row>
                </b-card>
            </b-col>
        </b-row>

    </b-container>

</template>

<script>

import CalendarEventAddForm from "./components/CalendarEventAddForm";
import CalendarList from "./components/CalendarList";
import dayjs from "dayjs";

export default {

    name: "App.vue",
    components: {
        CalendarEventAddForm,
        CalendarList
    },
    data() {
        return {
            events: [],
            selectedDate: dayjs(),
            isFetching: false,
        }
    },
    async created() {
        await this.refreshEvents();
    },
    methods: {
        async dateSelected(date) {
            await this.getEvents(date);
            this.selectedDate = date;
        },
        async getEvents(date) {
            this.isFetching = true;

            try {
                let response = await axios.get('/api/calendar/event/dates', {
                    params: {
                        year_month: date.format('YYYY-MM')
                    }
                });

                this.events = response.data.data;
            } catch (e) {
                console.log(e);
            } finally {
                this.isFetching = false;
            }
        },
        async eventAdded(event) {
            this.toastSuccess('The event is successfully added.')
            await this.refreshEvents();
        },
        async eventDeleted(event) {
            this.toastSuccess('The event is successfully deleted.')
            await this.refreshEvents();
        },
        async eventDateDeleted(date) {
            this.toastSuccess('The event date is successfully deleted.')
            await this.refreshEvents();
        },
        async refreshEvents() {
            await this.getEvents(this.selectedDate);
        },
        toast(variant, body, title) {
            this.$bvToast.toast(body, {
                title: title,
                variant: variant,
                solid: true
            })
        },
        toastSuccess(body) {
            this.toast('success', body, 'Success!')
        }
    }

}
</script>

<style scoped>
#main-container {
    padding: 20px;
}
</style>
