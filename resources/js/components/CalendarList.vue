<template>

    <div class="calendar-list">

        <div class="calendar-list-header">
            <calendar-date-selector
                :selected-date="selectedDate"
                @dateselected="dateSelected"
                :disable-selector="disableCalendar"
            />
        </div>

        <b-list-group>
            <calendar-list-item
                v-for="(day, index) in days"
                :key="day.date"
                :day="day"
                @eventdeleted="eventDeleted"
                @eventdatedeleted="eventDateDeleted"
            />
        </b-list-group>
    </div>

</template>

<script>
import dayjs from "dayjs";
import CalendarDateSelector from "./CalendarDateSelector";
import CalendarListItem from "./CalendarListItem";

export default {
    name: "CalendarList",
    props: {
        disableCalendar: {
            type: Boolean,
            required: false,
            default: false,
        },
        events: {
            type: Array,
            required: false,
            default: []
        },
        selectedDate: {
            type: Object,
            required: true
        },
    },
    components: {
        CalendarListItem,
        CalendarDateSelector
    },
    methods: {
        dateSelected(date) {
            this.$emit("dateselected", date);
        },
        eventDeleted(event) {
            this.$emit("eventdeleted", event);
        },
        eventDateDeleted(date) {
            this.$emit("eventdatedeleted", date);
        }
    },
    computed: {

        month() {
            return Number(this.selectedDate.format("M"));
        },
        year() {
            return Number(this.selectedDate.format("YYYY"));
        },
        daysInMonth() {
            return Number(this.selectedDate.daysInMonth());
        },
        days() {
            return [...Array(this.daysInMonth)].map((day, index) => {

                let d = dayjs(`${this.year}-${this.month}-${index + 1}`);

                let date = d.format("YYYY-MM-DD")

                let events = this.events.filter(e => e.date === date);

                return {
                    date: date,
                    dayWeek: d.format("DD ddd"),
                    events: events
                };
            });
        },
    }
}
</script>

<style scoped>

</style>
